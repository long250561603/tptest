<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/11/25
 * Time: 14:46
 */

namespace app\admin\controller;
use think\Loader;
use think\Db;
class Auth extends Base
{
    /**
     * 添加权限
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input();
            $res = model('auth')->allowField(true)->save($data);
            if ($res) {
                $this->success('操作成功', url('lst'));
            } else {
                $this->error('操作失败');
            }
        }

        //下拉菜单
        $authData = Loader::model('auth')->getTree();
        $this->assign('authData',$authData);
        return $this->fetch();
    }
    public function lst(){
        $authData = Loader::model('auth')->getTree();
        $this->assign('authData',$authData);
        return $this->fetch();
    }
    public function del(){
        $id =input('id');
        $rs = Db::name('auth')->where('id','=',$id)->delete();
        if ($rs) {
            return $this->success('删除成功', url('lst'));
        } else {
            return $this->error('删除失败');
        }
    }
    public function edt($id){
        if (request()->isPost()) {
            $data = input();
            $data['updatetime'] = time();
            if ($data['parentid'] == null) {
                $data['parentid'] = 0;
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