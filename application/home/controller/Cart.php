<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/19
 * Time: 10:49
 */

namespace app\home\controller;
use think\Loader;

class Cart extends Base
{
// 加入购物车
    public function addToCart(){
        $goodsId = input('goods_id');
        $goodsNumber = input('goods_number');
        $data = input();
        unset($data['goods_id']);
        unset($data['goods_number']);

        $goodsAttrId = implode(',', $data); // 18,22;

        // 加入到购物车存储
        Loader::model('cart')->addToCart($goodsId, $goodsNumber, $goodsAttrId);
        $this->success('加入购物车成功',url("Cart/cartList"));
    }
    //购物车列表
    public function cartList(){
        return $this->fetch();
    }
}