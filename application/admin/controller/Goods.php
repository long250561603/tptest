<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 22:38
 */

namespace app\admin\controller;

use Admin\Model\GoodsModel;
use think\Image;
use think\Db;
use think\Request;
use think\Loader;

/**
 * Class Goods
 * @package app\admin\controller
 * 商品类
 */
class Goods extends Base
{
    /**
     * @return mixed
     * 商品列表
     */
    public function lst()
    {
        $goodsData = db('goods')->where('is_delete', 0)->select();
        // 上传图片的根目录赋值给页面
        $rootPath = "/public";
        $this->assign('rootPath', $rootPath);
        $this->assign('goodsData', $goodsData);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 商品添加
     */
    public function add()
    {
        //判断是否提交过来
        if (request()->isPost()) {
            $data = request()->post();//接收提交过来的数据
            //$file = $this->request->file('goods_img');
            //   dump($file); die;
            if ($_FILES['goods_img']['tmp_name']) {
                $file = request()->file('goods_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $data['goods_img'] = '/uploads/' . $info->getSaveName();//获取保存起来的名称
            }
            $validate_result = $this->validate($data, 'Goods');//验证数据
            if ($validate_result !== true) {
                $this->error($validate_result);//错误信息
            } else {
                $res = model('goods');
                $rs = $res->allowField(true)->save($data);//插入全部数据
                $goodsId = $res->goods_id;//获取插入的ID
                if ($rs) {
                    //插入成攻后插入属性数据
                    $goodsAttr = $data['goodsAttr'];//获取属性值
                    $goodsAttrModel = Db::name('goods_attribute');//实例化属性表
                    foreach ($goodsAttr as $k => $v) {
                        // 1. 单选属性 二维码数组 $v 是一维数组
                        if (is_array($v)) {
                            foreach ($v as $k1 => $v1) {
                                $insertData = array(
                                    'goods_id' => $goodsId,
                                    'goods_attr_id' => $k,
                                    'goods_attr_value' => $v1, // $v1才是单选属性的商品属性值
                                );
                                $goodsAttrModel->insert($insertData);
                            }
                        } else {
                            // 2. 唯一属性
                            $insertData = array(
                                'goods_id' => $goodsId,
                                'goods_attr_id' => $k,
                                'goods_attr_value' => $v,
                            );
                            $goodsAttrModel->insert($insertData);
                        }
                    }
                    $this->success('操作成功', url('lst'));
                } else {
                    $this->error('操作失败');
                }
            }
        }
        $categoryData = Loader::model('category')->getTree();//递归获取商品分类
        $this->assign('categoryData', $categoryData);
        $typeData = Db::name('type')->select();//获取商品类型
        $this->assign('typeData', $typeData);
        return $this->fetch();
    }

    /**
     * @return mixed
     * 编辑商品
     */
    public function edt()
    {
        if (request()->isPost()) {
            $data = request()->post();
            if ($_FILES['goods_img']['tmp_name']) {
                $file = request()->file('goods_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $data['goods_img'] = '/uploads/' . $info->getSaveName();//获取保存起来的名称
            }
            $res = model('goods')->allowField(true)->save($data, ['goods_id' => $data['goods_id']]);
            if ($res) {
                $this->success('更新成功', url('lst'));
            } else {
                $this->error('更新失败');
            }
        } else {
            $id = input('id');//接收传递过来的商品ID
            $goodsInfo = Db::name('goods')->where('goods_id', $id)->find();//根据ID查询数据
            $this->assign('goodsInfo', $goodsInfo);

            $categoryData = Loader::model('category')->getTree();//递归获取商品分类
            $this->assign('categoryData', $categoryData);

            $typeData = Db::name('type')->select();//获取商品类型
            $this->assign('typeData', $typeData);

            // 上传图片的根目录赋值给页面
            $rootPath = "/public";
            $this->assign('rootPath', $rootPath);
            return $this->fetch();
        }
    }

    /**
     * 获取属性
     * AJXJ
     */
    public function getAttr()
    {
        $type_id = $this->request->get('type_id');//接收提交过来的类型ID
        $attrData = Db::name('attribute')->where('type_id', $type_id)->select();//查询
        echo json_encode($attrData);
        exit();
    }

    /**
     * 伪删除
     */
    public function del()
    {
        $goods_id = $this->request->get('goods_id');//接收提交过来的类型ID
        // 更新记录
        $res = Db::name('goods')
            ->where('goods_id', $goods_id)
            ->update(['is_delete' => '1']);
        if ($res) {
            $data = array(
                'sign' => 0,
                'code' => 'delete success',
                'msg' => '加入回收站成功',
            );
        } else {
            $data = array(
                'sign' => 1,
                'code' => 'delete success',
                'msg' => '删除失败',
            );
        }
        echo json_encode($data);
        exit();
    }
}