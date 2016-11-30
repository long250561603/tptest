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

        /*$roleLst = Db::table('it_role')->field('a.*, group_concat(b.tetle) tetle')->alias('a')->join('left join it_auth b on find_in_set(b.id,a.rules)')->group('a.id')->select();
        echo "<pre>";
        print_r($roleLst);die;*/
        $roleLst=db('role')->select();
        $this->assign('roleLst',$roleLst);
        return $this->fetch();
    }
    public function add(){
        //判读是否提交过来
        if ($this->request->isPost()) {
            $data = input();
            $count = db('role')->where('title', $data['title'])->count();
            if ($count) {
                $this->error('角色名已存在');
            }
            if (db('role')->insert($data) !== false) {
                $this->success('保存成功',url('lst'));
            } else {
                $this->error('保存失败');
            }
        }
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
            $res=db('role')->where('id',$id)->update($data);
            if ($res){
                $this->success('操作成功', url('lst'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $roleLst=db('role')->where('id',$id)->find();
            $this->assign('roleLst',$roleLst);
            return $this->fetch();
        }
    }
    /**
     * 授权
     * @param $id
     * @return mixed
     */
    public function auth($id) {
        $this->assign('id',$id);
        $rules= Loader::model("role")->where('id',$id)->value('rules');;
        $this->assign('rules',$rules);

        $authModel =Loader::model("auth");
        $authData = $authModel->getTree();
        $this->assign('authData', $authData);
        return $this->fetch();

    }
    public function authAdd($id){
        $data = input();
        $res=Loader::model("role")->where('id',$id)->setField('rules',implode(',', $data['rules']));
        if ($res){
            $this->success('操作成功', url('lst'));
        }else{
            $this->error('操作失败');
        }

    }


}