<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 22:38
 */

namespace app\admin\controller;


class Goods extends Base
{
    public function lst(){
        $goodsData = db('goods')->select();
        $this->assign('goodsData',$goodsData);
        return $this->fetch();
    }
    public function add(){
        if(request()->isPost()) {
            $data            = $this->request->post();
                $res = model('goods')->allowField(true)->save($data);
                if ($res) {
                    $this->success('操作成功', url('lst'));
                } else {
                    $this->error('操作失败');
                }
        }
        return $this->fetch();
    }
    public function edt(){
        return $this->fetch();
    }
}