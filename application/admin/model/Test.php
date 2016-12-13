<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/12
 * Time: 14:15
 */

namespace app\admin\model;


use think\Model;

class Test extends Model
{
    /*// 读取器
    protected function getUserBirthdayAttr($birthday, $data)
    {
        return date('Y-m-d', $data['birthday']);
    }
    // birthday修改器
    protected function setBirthdayAttr($value)
    {
        return strtotime($value);
    }*/
    // 定义类型转换
    protected $type = [
        'birthday'    => 'timestamp:Y/m/d',
    ];

    // 定义时间戳字段名
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
}