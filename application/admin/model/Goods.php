<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/6
 * Time: 14:41
 */

namespace app\admin\model;

use think\Model;
class Goods extends Model
{
    // 读取器
    protected function getGoodsCreatedAttr($created, $data)
    {
        return date('Y-m-d H:i:s', $data['created']);
    }

    // created修改器
    protected function setCreatedAttr($value)
    {
        if(empty($value)){
            return time();
        }else{
            // 将用户提交的时间字符串转换为一个时间戳
            return strtotime($value);
        }

    }
}