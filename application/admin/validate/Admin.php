<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate {
    protected $rule = [
        'username'         => 'require|unique:admin',
        'password'         => 'confirm:repassword',
        'repassword'       => 'confirm:password',
        'status'           => 'require',
        //'group_id'         => 'require'
    ];

    protected $message = [
        'username.require'         => '请输入用户名',
        'username.unique'          => '用户名已存在',
        'password.confirm'         => '两次输入密码不一致',
        'confirm_password.confirm' => '两次输入密码不一致',
        'status.require'           => '请选择状态',
        //'group_id'                 => '请选择所属权限组'
    ];
}