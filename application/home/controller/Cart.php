<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/19
 * Time: 10:49
 */

namespace app\home\controller;


class Cart extends Base
{
// 加入购物车
    public function addToCart(){
        $goodsId = input('goods_id');
        $goodsNumber = input('goods_number');
        $data = input();
        unset($data['goods_id']);
        unset($data['goods_number']);
        $goodsAttrId = implode(',', $data); // 18,22;k
    }
    //购物车列表
    public function cartList(){
        return $this->fetch();
    }
}