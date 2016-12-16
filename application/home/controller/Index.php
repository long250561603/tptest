<?php
namespace app\home\controller;

use think\Db;

class Index extends Base
{
    public function index()
    {
        //图片地址
        $viewPath = "/public";
        $this->assign('viewPath', $viewPath);
        //获取新品
        $newData  =Db::name('goods')->where('is_new',1)->where('is_delete',0)->where('is_sale',1)->select();
        $this->assign('newData',$newData);
        //获取热销
        $hotData  =Db::name('goods')->where('is_hot',1)->where('is_delete',0)->where('is_sale',1)->select();
        $this->assign('hotData',$hotData);
        //获取精品
        $bestData  =Db::name('goods')->where('is_best',1)->where('is_delete',0)->where('is_sale',1)->select();
        $this->assign('bestData',$bestData);
        return $this->fetch();
    }
}
