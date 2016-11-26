<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/11/25
 * Time: 13:35
 */

namespace app\admin\controller;
use think\Db;
use think\Input;
use think\Loader;
use think\Request;
/*
 * 角色类
 * */
class Role extends Base
{
    /**
     * 角色列表
     */
    public function lst(){
        $roleLst=db('role')->select();
        $this->assign('roleLst',$roleLst);
        return $this->fetch();
    }
    public function add(){
        //判读是否提交过来
        if(request()->isPost()) {
            $data = input();
            $count = db('role')->where('name', $data['name'])->count();
            if ($count) {
                $this->error('用户名已存在');
            }
            $data = ['name'=>$data['name'],'updatetime'=>time(),'rules'=>$data['rules']];
            $res = db('role')->insert($data);
            if ($res){
                $this->success('操作成功', url('lst'));
            }else{
                $this->error('操作失败');
            }
        }
        $authData = Loader::model('auth')->getTree();
        $this->assign('authData',$authData);

        return $this->fetch();
    }

    /**
     * 删除
     */
    public function del(){
        $id = input('id');
        $res=db('role')->delete($id);
        if ($res){
            $this->success('操作成功', url('lst'));
        }else{
            $this->error('操作失败');
        }
    }
    public function edt($id){
        if (request()->isPost()){
            $data = input();
            $data = ['name'=>$data['name'],'updatetime'=>time(),'rules'=>$data['rules']];
            $res=db('role')->where('id',1)->update($data);
            if ($res){
                $this->success('操作成功', url('lst'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $roleLst=db('role')->where('id',$id)->find();
            $this->assign('roleLst',$roleLst);
            $authData = Loader::model('auth')->getTree();
            $this->assign('authData',$authData);
            return $this->fetch();
        }

    }
}