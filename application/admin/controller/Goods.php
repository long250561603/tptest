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
        return $this->fetch();
    }
    public function add(){
        return $this->fetch();
    }
}