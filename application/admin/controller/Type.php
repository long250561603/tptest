<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/8
 * Time: 14:25
 */

namespace app\admin\controller;
use think\Db;
/**
 * Class Type
 * @package app\admin\controller
 * 商品类型
 */
class Type extends Base
{
    /**
     * 添加商品类型
     */
    public function add(){
        if(request()->isPost()) {
            $data            = $this->request->post();
            $res = model('type')->allowField(true)->save($data);
            if ($res) {
                $this->success('操作成功', url('lst'));
            } else {
                $this->error('操作失败');
            }
        }
        return $this->fetch();
    }

    /**
     * @return mixed
     * 商品类型列表
     */
    public function lst(){
        $typeLst=db('type')->select();
        $this->assign('typeLst',$typeLst);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 商品属性列表
     */
    public function showAttr(){
        $type_id =input('id');
        $this->assign('type_id',$type_id);
        $attributeData = Db::name('attribute')->where('type_id',$type_id)->select();
        $this->assign('attributeData',$attributeData);
        return $this->fetch();
    }
}