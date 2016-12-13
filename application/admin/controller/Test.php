<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/12
 * Time: 14:15
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Test as TestModel;

class Test extends Controller
{
    // 读取用户数据1
    public function read($id='2')
    {
        $user = TestModel::get($id);
        echo $user->nickname . '<br/>';
        echo $user->email . '<br/>';
        echo $user->birthday . '<br/>';
        //echo $user->user_birthday . '<br/>';
    }
    // 新增用户数据
    public function add()
    {
        $user           = new TestModel;
        $user->nickname = '流年';
        $user->email    = 'thinkphp@qq.com';
        $user->birthday = '1977-03-05';
        if ($user->save()) {
            return '用户[ ' . $user->nickname . ':' . $user->id . ' ]新增成功';
        } else {
            return $user->getError();
        }
    }
}