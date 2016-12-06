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
        $this->checkAuth();
        // 2. 做session验证
        
    }
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth() {
        // 2. 做session验证
        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }
        $module     = $this->request->module();//获取当前的模块名
        $controller = $this->request->controller();//获取当前的控制器名
        $action     = $this->request->action();//获取当前的操作名
        // 3. 验证当前用户是否存在相应的权限
        $accessControllerAction = $controller .'/'. $action;//Admin/lst"

        //4. 后台的一些公共权限应该公开，每一个用户应该都存在
        // Index/index Index/head Index/left Index/right
        if($controller == 'Index'){
            return true; // 终止验证
        }

        // 5. 逻辑判断
        $auth = session('auth');
        // 超级管理员不受限制
        // 如果不是超级管理员，并且它所访问的权限不在它的session数据里面，则
        // 无权访问
        if($auth != '*' && !in_array($accessControllerAction, $auth)){
            $this->error('无权访问', 'Index/index');
        }

    }
    
}