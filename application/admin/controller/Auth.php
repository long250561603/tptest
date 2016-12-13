<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/11/25
 * Time: 14:46
 */

namespace app\admin\controller;
use think\Db;
use think\Input;
use think\Loader;
use think\Request;

/***
 * Class Auth
 * @package app\admin\controller
 * 权限类
 */
class Auth extends Base
{
    /**
     * 添加权限
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input();
            $res=db('auth')->insert($data);
           if ($res){
               return $this->success('添加成功', url('lst'));
           }else{
               return $this->error('删除失败');
           }
        }else{
            //下拉菜单
            $authData = Loader::model('auth')->getTree();
            $this->assign('authData',$authData);
            return $this->fetch();
        }
    }
    /*
     * 权限列表
     */
    public function lst(){
        $authData = Loader::model('auth')->getTree();
       
    // 把分页数据赋值给模板变量list
        $this->assign('authData',$authData);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 删除权限
     */
    public function del(){
        $id =input('id');
        $rs = Db::name('auth')->where('id','=',$id)->delete();
        if ($rs) {
            return $this->success('删除成功', url('lst'));
        } else {
            return $this->error('删除失败');
        }
    }

    /***
     * @param $id
     * @return mixed
     * 编辑权限
     */
    public function edt($id){
        if (request()->isPost()) {
            $data = input();
            if ($data['pid'] == null) {
                $data['pid'] = 0;
            }
            $res = model('auth')->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res) {
                $this->success('操作成功', url('lst'));
            } else {
                $this->error('操作失败');
            }
        }
        $authData = Loader::model('auth')->getTree();
        $this->assign('authData',$authData);
        $authInfo=db('auth')->where('id',$id)->find();;
        $this->assign('authInfo',$authInfo);
        return $this->fetch();
    }
}