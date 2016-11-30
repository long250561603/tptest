<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/26
 * Time: 20:35
 */

namespace app\admin\controller;


use think\Controller;
use think\auth\Auth;
use think\Loader;
use think\Cache;
use think\Db;
use think\Session;
/***
 * Class Base
 * @package app\index\controller
 * 基础类
 */
class Base extends Controller
{
    //
    protected function _initialize() {
        parent::_initialize();
    }
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth() {

        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }

        $module     = $this->request->module();//获取当前的模块名
        $controller = $this->request->controller();//获取当前的控制器名
        $action     = $this->request->action();//获取当前的操作名

        // 排除权限
        $not_check = ['admin/Index/index', 'admin/AuthGroup/getjson', 'admin/System/clear'];

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth     = new Auth();
            var_dump($auth);die;
            $admin_id = Session::get('admin_id');
            var_dump($admin_id);
            if (!$auth->check($module . '/' . $controller . '/' . $action, $admin_id) && $admin_id != 1) {
                $this->error('没有权限');
            }
        }
    }
    
}