<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/11/3
 * Time: 10:08
 */

namespace app\admin\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class Admin extends Validate
{

    protected $rule = [
        'username' => 'require|checkHasValue:username|alphaNum',
        'password' => 'require',
        'repassword' => 'require|confirm:password',

    ];
    protected $message = [
        'username.require ' => '用户名不能为空',
        'username.checkHasValue:username' => '用户名已存在',
        'username.alphaNum' => '用户名必须是字母、数字',

        'password.require' => '请输入密码',
        'repassword.require' => '请输入密码',
        'repassword.confirm' => '请重新输入确认密码',

    ];
    protected $scene = [
        'edt'                 =>  ['username'],
        'add'                  =>  ['username','password','repassword'],
    ];

    protected function checkHasValue($value, $rule)
    {
        $id = input('id');

        switch ($rule) {
            case 'username':
                $hasValue = Db::name('Admin')->where('username', $value)->find();
                if (empty($hasValue)) {
                    return true;
                } else {
                    return '用户名已存在';
                }
            default:
                # code...
                break;
        }
    }
}