<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/11/25
 * Time: 15:03
 */

namespace app\admin\model;


use think\Model;

class Auth extends Model
{
    public $display = array('1' => '显示', '2' => '不显示');
    /*
     *
     */
    public function selectAuth(){
        $res = db('auth')
            ->field('id,name,parentid')
            ->order('listorder asc')
            ->select();
        $tmpArr = nodeTree($res);
        $data = array();
        foreach ($tmpArr as $k => $v) {
            $name = $v['level'] == 0 ? '<b>' . $v['name'] . '</b>' : '├─' . $v['name'];

            $name = str_repeat("│        ", $v['level']) . $name;
            $data[$v['id']] = $name;
        }
        return $data;
    }
    // 获取所有的权限
    public function getTree()
    {
        $data = db('auth')->select();
        return $this->_getTree($data, $pid = 0, $level = 0);
    }

    // 递归实现数据排序
    public function _getTree($data, $pid = 0, $level = 0)
    {
        // 递归实现体
        static $list = array();
        foreach ($data as $k => $v) {

            if($v['parentid'] == $pid){
                $v['level'] = $level;
                $list[] = $v;
                // 递归调用
                $this->_getTree($data, $v['id'], $level+1);
            }

        }

        return $list; // 返回数据
    }
}