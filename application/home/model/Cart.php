<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2017/2/17
 * Time: 16:35
 */

namespace app\home\model;


use think\Model;

class Cart extends Model
{
    //加入购物车分两种情况，登陆或为登入
    public function addToCart($goodsId, $goodsNumber, $goodsAttrId){
        $userId = session('uid');
        if ($userId){
            // 保存在mysql数据库，先去检测原先是否有把该件商品加入过购物车
            $where = " goods_id = $goodsId and goods_attr_id = '$goodsAttrId' and user_id = $userId";
            $info = $this->where($where)->find();
        }else{
            // 保存在cookie里面
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            // 检测cookie曾经是否加入过该商品
            // goods_id-goods_attr_id=>goods_number
            // 拼接下标
            $key = $goodsId .'-'. $goodsAttrId;
            //dump($key);die;
            if($cart[$key]){
                // 曾经加入购物车
                $cart[$key] += $goodsNumber;

            }else{
                // 没有加入
                $cart[$key] = $goodsNumber;

            }
            // 数据重新的写回cookie
            $time = time() + 86400 * 7;  // 保存一个星期
            setcookie('cart', serialize($cart), $time , '/');
        }
    }
}