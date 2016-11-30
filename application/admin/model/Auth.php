<?php
namespace app\admin\model;

use think\Model;

class Auth extends Model {
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

            if($v['pid'] == $pid){
                $v['level'] = $level;
                $list[] = $v;
                // 递归调用
                $this->_getTree($data, $v['id'], $level+1);
            }

        }

        return $list; // 返回数据
    }
}