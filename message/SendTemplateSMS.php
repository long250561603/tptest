<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */

include_once("./CCPRestSmsSDK.php");

// 核心类文件，完成短信接口私有
//主帐号,对应开官网发者主账号下的 ACCOUNT SID
$accountSid= '8a48b5514b35422d014b521ba5370da7';

//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
$accountToken= '8a7dc61d876740cd93ca57453d4d2faa';

//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
$appId='8a48b5514b35422d014b521d805a0da8';

//请求地址
//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
//生产环境（用户应用上线使用）：app.cloopen.com

// 由于没有正式上线只能使用沙盒 沙盘演练
$serverIP='sandboxapp.cloopen.com';


//请求端口，生产环境和沙盒环境一致
$serverPort='8883';

//REST版本号，在官网文档REST介绍中获得。
$softVersion='2013-12-26';


/**
  * 发送模板短信
  * @param to 手机号码集合,用英文逗号分开
  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
  */       
function sendTemplateSMS($to,$datas,$tempId)
{
     global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
    
     // 发送模板短信
     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     if($result == NULL ) {
         return array(
            'sign' => 1,
            'msg' => 'result error!',
         );
     }
     if($result->statusCode!=0) {
         return array(
            'sign' => 2,
            'msg' => $result->statusCode . '==' . $result->statusMsg,
         );
     }else{
         // 获取返回信息
         $smsmessage = $result->TemplateSMS;
         return array(
            'sign' => 0,
            'msg' => $smsmessage->dateCreated,
        );
     }
}

/**
 * 生成随机字符串
 * @param int       $length  要生成的随机字符串长度
 * @param string    $type    随机码类型：0，数字+大小写字母；
 * 1，数字；2，小写字母；3，大写字母；4，特殊字符；
 * -1，数字+大小写字母+特殊字符
 * @return string
 */
 function randCode($length = 5, $type = 0) {
    $arr = array(
        1 => "0123456789", 
        2 => "abcdefghijklmnopqrstuvwxyz", 
        3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 
        4 => "~@#$%^&*(){}[]|"
    );

    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } elseif ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $string[rand(0, $count)];
    }
    return $code;
 }


//手机号码，替换内容数组，模板ID
// 注意：使用该功能需要开启PHP的curl扩展
// extension=php_curl.dll
// 1. 获取手机号码
$telephone = $_GET['telephone'];
// 2. 生成验证码
$code = randCode(4, 1);
// 3. 定义一个有效时间
$time = 5; // 5分钟
// 4. 调用函数发送短信，理论上要得到返回的状态码
$res = sendTemplateSMS($telephone, array($code, $time), "1");
// 正确发送
if($res['sign'] == 0){
    // 将生成的验证保存在cookie 或者session
    setcookie('code', $code, time() + $time * 60, '/');
    $data = array(
        'sign' => 0,
        'msg' => 'send success',
    );
    echo json_encode($data);
    exit();
}else{
    $data = array(
        'sign' => $res['sign'],
        'msg' => $res['msg'],
    );
    echo json_encode($data);
    exit();

}
?>