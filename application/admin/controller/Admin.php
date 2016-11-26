<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/10/25
 * Time: 10:46
 */

namespace app\admin\controller;

use think\Db;
use think\Input;
use think\Loader;
use think\Request;

class Admin extends Base
{
    /***
     * @return wuyanlong
     * 添加管理员
     */
    public function add()
    {
        //判读是否提交过来
        if(request()->isPost()) {
            $data = input();//接收数据
            $count = db('admin')->where('username', $data['username'])->count();

            if ($count) {
                $this->error('用户名已存在');
            }

            if ($data['password'] != $data['repassword']) {
                $this->error('两次密码不一致');
            }

            $data['password'] = md5($data['password']);//MD5加密
            $res = model('admin')->allowField(true)->save($data);
            if ($res) {
               /* if (isset($data['groups'])) {
                    $uid = model('Admin')->id;
                    foreach ($data['groups'] as $v) {
                        db('admin_group_access')->insert(['uid' => $uid, 'group_id' => $v]);
                    }
                }*/
                $this->success('操作成功', url('lst'));
            } else {
                $this->error('操作失败');
            }
        }
        return $this->fetch();
    }

    /***
     * 用户列表
     * @return mixed
     */
    public function lst()
    {
        $adminLst = Db::name('Admin')->select();
        $this->assign('adminLst', $adminLst);
        return $this->fetch();
    }

    /***
     * @param $id
     * @return mixed|void
     */
    public function edt($id)
    {
        if (request()->isPost()) {
            $data = input();
            if (!$data['password']) {
                unset($data['password']);
            } else {
                if ($data['password'] != $data['repassword']) {
                    $this->error('两次密码不一致!');
                }
                $data['password'] = md5($data['password']);
            }
            $res = Loader::model('Admin')->editInfo(2, $data['id'], $data);

            if ($res) {
                $this->success('操作成功',url('lst'));
            } else {
                $this->error('操作失败');
            }
        } else {
            // 查询单条数据
            if (empty($id)) {
                return $this->error('请选择有效数据');
            }
            $map['id']     = $id;
            $adminInfo      = Db::name('admin')->where($map)->find();
            $this->assign('adminInfo',$adminInfo);
            return $this->fetch('edt');
        }

    }

    /***
     * 删除
     */
    public function del()
    {
        $id =input('id');
        $rs = Db::name('Admin')->where('id','=',$id)->delete();
        if ($rs) {
            return $this->success('删除成功', url('lst'));
        } else {
            return $this->error('删除失败');
        }
    }
}