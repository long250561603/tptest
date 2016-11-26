<?php
namespace app\admin\controller;

class Index extends Base
{
    //载入模板
    public function index()
    {
        return $this->fetch();
    }
    public function head(){
        return $this->fetch();
    }
    public function left(){
        return $this->fetch();
    }
    public function right(){
        return $this->fetch();
    }

}
