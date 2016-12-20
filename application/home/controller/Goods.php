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

        // 1. 先获取商品属性，由于只需要获取单选属性，所以需要联表操属性表，获取属性类型
        $attrData=Db::name('goods_attribute')
            ->alias('a')
            ->join('it_attribute b','a.goods_attr_id = b.attr_id')
            ->where('a.goods_id',$goods_id)
            ->select();
        // 2. 处理商品属性，取出单选属性
        $radioData = array();
        foreach ($attrData as $k => $v) {
            if($v['attr_type'] == 1){
                $radioData[$v['attr_id']][] = $v; // 将相同的单选属性保存在一个数组里面
            }
        }
        $this->assign('radioData', $radioData);

        //图片地址
        $viewPath = "/public";
        $this->assign('viewPath', $viewPath);
        return $this->fetch();
    }
}