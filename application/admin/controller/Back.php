<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/10/28
 * Time: 16:39
 */

namespace app\admin\controller;


class Back extends Base
{
    //登陆
    public function login(){
        if(is_post()){
            $data = input('post.','','trim');
            $captcha = new \think\captcha\Captcha();
            if (!$captcha->check($data['captcha'])) {
                $this->returnJSON('','验证码错误',config('code.code_error'));
            }
            $user = model('Authuser');
            $result = $user->is_login_user($data['name'],md5($data['password']));
            if(!$result){
                $this->returnJSON('','登录失败,请检查用户名和密码',config('code.error'));
            }else{
                session('user',$data['name']);
                session('uid',$result['id']);
                $this->returnJSON('','登录成功',config('code.success'));
            }
        }else{
            return $this->fetch();
        }
    }
}