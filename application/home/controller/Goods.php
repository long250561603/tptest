<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/16
 * Time: 15:13
 */

namespace app\home\controller;


use think\Db;

class Goods extends Base
{
    public function detail(){
        $goods_id = input('id');
        $goodsInfo = Db::name('goods')->where('goods_id',$goods_id)->find();
        $this->assign('goodsInfo', $goodsInfo);
        //图片地址
        $viewPath = "/public";
        $this->assign('viewPath', $viewPath);
        return $this->fetch();
    }
}