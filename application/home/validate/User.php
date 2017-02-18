<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/21
 * Time: 11:32
 */
namespace app\home\validate;

use think\Validate;
class User extends Validate
{
    protected $rule = [
        'username'         => 'require|unique:User',
        'email'            => 'require|unique:User|email',
        'telephone'        => 'require|unique:User|number',
        'password'         => 'confirm:repassword',
        'repassword'       => 'confirm:password',
    ];
    protected $message = [
        'username.require'         => '请输入用户名',
        'username.unique'          => '用户名已存在',
        'email.require'            => '请输入邮箱',
        'email.unique'             => '邮箱已存在',
        'telephone.require'        => '请输入手机',
        'telephone.unique'         => '手机已存在',
        'email.email'              => '邮箱格式错误',
        'password.confirm'         => '两次输入密码不一致',
        'repassword.confirm'       => '两次输入密码不一致',
    ];
}