<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/8
 * Time: 14:46
 */

namespace app\admin\controller;

use think\Db;
use think\Input;
use think\Loader;
use think\Request;

/**
 * Class Category
 * @package app\admin\controller
 * 商品分类
 */
class Category extends Base
{
    /**
     * @return mixed|void
     * 添加商品分类
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input();
            $res = db('category')->insert($data);
            if ($res) {
                return $this->success('添加成功', url('lst'));
            } else {
                return $this->error('失败');
            }
        }
        //下拉菜单
        $category = Loader::model('category')->getTree();
        $this->assign('category', $category);
        return $this->fetch();
    }

    /***
     * @return mixed
     * 商品分类列表
     */
    public function lst()
    {
        $categoryLst = Loader::model('category')->getTree();
        $this->assign('categoryLst', $categoryLst);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 商品分类删除
     */
    public function del(){
        return $this->fetch();
    }
}