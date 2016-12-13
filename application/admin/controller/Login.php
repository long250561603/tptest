<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/28
 * Time: 21:36
 */

namespace app\admin\controller;
use think\Config;
use think\Controller;
use think\Db;
use think\Session;

/***
 * Class Login
 * @package app\admin\controller
 * 登陆类
 */
class Login extends Controller
{
    /***
     * @return mixed
     * 登录主页面
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 登录方法
     */
    public function login(){
        $data            = $this->request->only(['username', 'password', 'verify']);
        $validate_result = $this->validate($data, 'Login');
        if ($validate_result !== true) {
            $this->error($validate_result);
        } else {
            $where['username'] = $data['username'];
            $where['password'] = md5($data['password'] . Config::get('salt'));
            $admin_user = Db::name('admin')->field('id,username,status,role_id')->where($where)->find();
            if (!empty($admin_user)) {
                if ($admin_user['status'] != 1) {
                    $this->error('当前用户已禁用');
                } else {
                    Session::set('admin_id', $admin_user['id']);
                    Session::set('admin_name', $admin_user['username']);
                    Session::set('role_id',$admin_user['role_id']);
                    Db::name('admin')->update(
                        [
                            'last_login_time' => date('Y-m-d H:i:s', time()),
                            'last_login_ip'   => $this->request->ip(),
                            'id'              => $admin_user['id']
                        ]
                    );
                    // 登入成功，需要将用户的角色权限保存到session中
                    $this->_putAuthToSession($admin_user['role_id']);
                    $this->_putAuthToSession($admin_user['role_id']);
                    $this->success('登录成功', 'admin/index/index');
                }
            } else {
                $this->error('用户名或密码错误');
            }
        }

    }
    /**
     * 退出登录
     */
    public function logout() {
        Session::delete('admin_id');
        Session::delete('admin_name');
        $this->success('退出成功', 'admin/login/index');
    }
    // 1. 将对应角色的权限保存到session里面
    // 2. 还要将用户对应的权限菜单保存在session里面
    private function _putAuthToSession($roleId)
    {
        // 实例化角色模型
        $roleModel = db("role");
        // 对应角色信息
        $roleInfo = Db::table('it_role')->field(['rules'])->find($roleId);
        // 1. 超级管理员，不受权限的控制
        if ($roleInfo['rules'] == '*') {
            // 超级管理员
            session('auth', '*');
            // 注意：超级管理员要取出所有的顶级权限+二级权限
            $menu = array();
            $authModel = db('auth');
            // 顶级权限取出所有
            $menu = $authModel->where('pid=0')->select();
            // 顶级权限的下级权限
            foreach ($menu as $k => $v) {
                $menu[$k]['sub'] = $authModel->where(' pid= ' . $v['id'])->select();
            }
            // 保存超级管理员的菜单
            session('menu', $menu);
        } else {
            // 一般角色
            // // 根据role_id_list 查询权限表
            $authModel = db('auth');
            $_authData = $authModel->where("id in ({$roleInfo['rules']})")->select();
            // 将上面的二维转换为一维
            // array('Admin/add','Admin/lst','Order/add','Order/lst');
            $authData = array();
            $menu = array();
            // 取出顶级菜单
            //
            foreach ($_authData as $k => $v) {
                if ($v['pid'] == 0) {
                    $menu[] = $v;
                }
                $authData[] = $v['name'];
            }
            session('auth', $authData);
            // 获取二级权限
            foreach ($menu as $k => $v) {
                foreach ($_authData as $k1 => $v1) {
                    if ($v1['pid'] == $v['id']) {
                        $menu[$k]['sub'][] = $v1;
                    }
                }
            }
            // 权限保存到session
            session('menu', $menu);
        }
    }
}