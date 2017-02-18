<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/21
 * Time: 11:21
 */

namespace app\home\controller;

class User extends Base
{
    /**
     * 用户注册
     */
    public function register(){
        //判断是否提交
        if (request()->isPost()){
            $data= $this->request->post();//接收数据
            $validate_result = $this->validate($data,'User');//验证数据
            //dump($validate_result);die;
            if ($validate_result !== true) {
                $this->error($validate_result);
            }else {
                // 生成token
                $token = uniqid(); // 生成一个唯一的字符串，基于微妙产生的
                $token = md5($token);
                $data['token'] = $token;
                $data['regtime'] = time();
                $data['password'] = md5($data['password']);//MD5加密
                $res = model('user');
                $rs=$res->allowField(true)->save($data);
                //
                $email =$res->email;
                $userId = $res->id;
                $userId = base64_encode($userId);
                if ($rs) {
                    $content = "注册成功，请<a href='http://local.tptest.com/index.php/Home/User/active/id/{$userId}/token/{$token}'>激活</a>";
                    $res = sendMail($email, '网站', $content);
                    if($res['sign'] == 1){
                        // 将错误返回给用户
                         $this->error = $res['msg'];
                        return false;
                    }
                }
            }
        }
        return $this->fetch();
    }
    public function active(){
        $userId = input('id');
        $token = input('token');
        $userId = base64_decode($userId);
        $userModel=model('user');
        $userInfo = $userModel->where('id',$userId)->find();
        if($userInfo){
            // 用户名存在
            if($userInfo['is_active'] == 1){
                // 曾经已经激活过
                $this->error('您的账号已成功激活，请直接登录',url("User/login"));
            }else{
                // 为每一个用户单独生成，每一个用户都不一样
                if($userInfo['token'] == $token){
                    // 合法请求
                    $userModel->where(array('id'=>$userId))->setField('is_active', 1);
                    $this->success('处理成功！', url('User/login'));
                    exit();
                }else{
                    // 非法请求
                    $this->error("非法请求");
                }
            }
        }else{
            $this->error('用户名不存在',url("User/register"));

        }

    }
    public function login(){
        return $this->fetch();
    }
}