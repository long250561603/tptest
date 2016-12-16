<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/8
 * Time: 15:01
 */

namespace app\home\model;


use think\Model;

class Base extends Model
{
    // 获取所有的权限
    public function getTree()
    {
        $data = db('category')->select();
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
                $this->_getTree($data, $v['cat_id'], $level+1);
            }

        }

        return $list; // 返回数据
    }
}