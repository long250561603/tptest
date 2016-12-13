<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/13
 * Time: 9:54
 */

namespace app\admin\validate;


use think\Validate;

class Goods extends Validate
{
    // 验证规则
    protected $rule = [
        'goods_name' => 'require',
        'goods_price'    => 'number',
        'goods_number' => 'number',
        'type_id' => 'require',
        'cat_id' => 'require',
    ];
    protected $message = [
        'goods_name.require'         => '请输入商品名称',
        'goods_price.number'         => '必须为数字',
        'goods_number.number'        => '必须为数字',
        'type_id.require'             => '请选择商品类型',
        'cat_id.require'             => '请选择商品分类',
    ];
}