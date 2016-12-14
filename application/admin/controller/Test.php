<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/12
 * Time: 14:15
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Test as TestModel;
use think\Request;
class Test extends Controller
{
    // 文件上传提交
    public function up()
    {
        if (request()->isPost()) {
            // 获取表单上传文件
            $file = $this->request->file('file');
            if (empty($file)) {
                $this->error('请选择上传文件');
            }
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $this->success('文件上传成功：' . $info->getRealPath());
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }else{
            return $this->fetch();
        }
    }
}