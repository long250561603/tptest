<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 数组层级缩进转换
 * @param array $array
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1) {
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }

    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array 要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid 父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid = 'pid', $child_key_name = 'children') {
    $counter = array_children_count($array, $pid);
    if ($counter[0] == 0)
        return false;
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param $array
 * @param $pid
 * @return array
 */
function array_children_count($array, $pid) {
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name) {
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */
function delete_dir_file($dir_name) {
    $result = false;
    if(is_dir($dir_name)){
        if ($handle = opendir($dir_name)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    if (is_dir($dir_name . DS . $item)) {
                        delete_dir_file($dir_name . DS . $item);
                    } else {
                        unlink($dir_name . DS . $item);
                    }
                }
            }
            closedir($handle);
            if (rmdir($dir_name)) {
                $result = true;
            }
        }
    }

    return $result;
}

/**
 * 判断是否为手机访问
 * @return  boolean
 */
function is_mobile() {
    static $is_mobile;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}
/**
 * 邮件发送函数
 * @param  string $to      邮件接收者
 * @param  string $from    邮件发送者
 * @param  string $content 邮件内容
 * @return 无
 */
function sendMail($to, $from, $content){
    /*
     * sohu 邮箱测试：smtp.sohu.com
     * username: gogery@sohu.com
     * password: php1234
    */

    header("Content-type:text/html;charset=utf-8");
    //引入邮件类
    require '/mail/class.phpmailer.php';

    $mail = new PHPMailer();

    /*服务器相关信息*/
    $mail->IsSMTP();    //设置使用SMTP服务器发送
    $mail->SMTPAuth   = true;     //开启SMTP认证
    //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Host       = 'smtp.sohu.com';

    // 自己配置  在搜狐注册的账号
    $mail->Username   = 'gogery';  	//发信人的邮箱用户名
    $mail->Password   = 'php1234';  //发信人的邮箱密码

    /*内容信息*/
    // 邮件内容是否支持html标签
    $mail->IsHTML(true);
    $mail->CharSet    ="UTF-8";	//编码
    $mail->From       = 'gogery@sohu.com';	 //发件人完整的邮箱名称
    $mail->FromName   = $from;	//发信人署名
    $mail->Subject    = "PHP邮件";  	 //信的标题
    $mail->MsgHTML( $content );  	//发信主体内容
    $mail->AddAddress( $to );  //收件人地址

    //使用send方法进行发送
    if( $mail->Send() ) {

        return array(
            'sign' => 0,
            'code' =>'send success',
            'msg' =>'success',
        );

    } else {
        //如果发送失败，则返回错误提示
        return array(
            'sign' => 1,
            'code' =>'send failure',
            'msg' => $mail->ErrorInfo,
        );

    }

}