<?php
namespace app\admin\model;

use think\Model;

class Role extends Model {
    // 获取所有的权限
    public function getTree()
    {
        $data = db('auth')->select();
        return $this->_getTree($data, $pid = 0, $level = 0);
    }

    // 添加、将权限数组转换为以逗号分隔的字符串
    public function _before_insert(&$data, $option)
    {
        $data['rules'] = implode(',', $data['rules']);

    }

    // 更新、将权限数组转换为以逗号分隔的字符串
    public function _before_update(&$data, $option)
    {
        $data['rules'] = implode(',', $data['rules']);
    }
}