<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/26
 * Time: 20:33
 */
namespace app\admin\controller;
use think\Config;
use think\Db;
use think\Loader;
use think\Request;
/**
 * Class Admin
 * @package app\index\controller
 * 后台管理员
 */
class Admin extends Base
{
    /**
     * @return mixed
     *
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * @return mixed
     * 管理有列表
     */
    public function lst(){
        $adminLst=Db::table('it_admin')
            ->alias('a')
            ->join('it_role b','a.role_id= b.id')
            ->select();
        $this->assign('adminLst', $adminLst);
        return $this->fetch();
    }

    /**
     * @param $id
     * @return mixed|void
     * 编辑管理员
     */
    public function edt($id){
        if (request()->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Admin');
            if ($validate_result !== true) {
                $this->error($validate_result);
            }else{
                $admin           = Loader::model('Admin')->find($id);
                $admin->id       = $id;
                $admin->username = $data['username'];
                $admin->status   = $data['status'];
                $admin->role_id  = $data['role_id'];
                if (!empty($data['password']) && !empty($data['repassword'])) {
                    $admin->password = md5($data['password'] . Config::get('salt'));
                }
                if ($admin->save() !== false) {
                    $this->success('更新成功',url('lst'));
                } else {
                    $this->error('更新失败');
                }
            }
        }else {
                // 查询单条数据
                if (empty($id)) {
                    return $this->error('请选择有效数据');
                }
                $map['id']     = $id;
                $adminInfo      = Db::name('admin')->where($map)->find();
                $this->assign('adminInfo',$adminInfo);
                $roleLst=db('role')->select();
                $this->assign('roleLst',$roleLst);
                return $this->fetch('edt');
            }
    }

    /**
     * @return mixed
     * 添加管理员
     */
    public function add(){
        //判读是否提交过来
        if(request()->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Admin');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['password'] = md5($data['password']);//MD5加密
                $res = model('admin')->allowField(true)->save($data);
                if ($res) {
                    $this->success('操作成功', url('lst'));
                } else {
                    $this->error('操作失败');
                }
            }
        }
        $roleLst=db('role')->select();
        $this->assign('roleLst',$roleLst);
        return $this->fetch();
    }

}