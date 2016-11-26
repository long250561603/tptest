<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'index';
    }

    public function hello($name = 'World')
    {
        return 'Hello,' . $name . '!';
    }
}