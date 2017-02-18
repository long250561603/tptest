<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/10
 * Time: 16:30
 */

namespace app\admin\controller;
use think\Db;
use think\Request;

/***
 * Class Attribute
 * @package app\admin\controller
 * 商品属性类
 */
class Attribute extends Base
{
    /**
     * @return mixed
     * 添加属性
     */
    public function add(){

        $type_id =input('type_id');//传递过的类型ID
        if(request()->isPost()) {
            $data            = $this->request->post();//数据
            $res = model('attribute')->allowField(true)->save($data);
            if ($res) {
                $this->success('操作成功', url('Type/showAttr',"id=$type_id"));
            } else {
                $this->error('操作失败');
            }
        }
        $this->assign('type_id',$type_id);
        $type=Db::name('type')->select();
        $this->assign('type',$type);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 编辑属性
     */
    public function edt(){
        return $this->fetch();
    }

    /**
     * @return mixed
     * 删除属性
     */
    public function del(){
        return $this->fetch();
    }

}