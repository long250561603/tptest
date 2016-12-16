<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/16
 * Time: 11:45
 */

namespace app\home\controller;


use think\Controller;

use think\Loader;
class Base extends Controller
{
    //初始化
    protected function _initialize() {
        parent::_initialize();
        // 把一些功能的操作放在这里完成
        // 导航栏
        // 首页导航栏获取
        // 注意：一般前后台操作数据的时候，使用一个数据模型
        // 实例化后台的Category
        // 局部的
        $categoryData = Loader::model('admin/category')->where('pid',0)->select();
        $this->assign('categoryData',$categoryData);

        //下拉菜单
        $category = Loader::model('admin/category')->getTree();
        $this->assign('category', $category);
    }
}