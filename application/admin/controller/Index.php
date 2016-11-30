<?php
namespace app\admin\controller;
use think\Db;
use think\Session;
class Index extends Base
{
    protected function _initialize() {
        parent::_initialize();
    }
    /**
     * 首页
     * @return mixed
     */
    public function index() {
        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }
        $version = Db::query('SELECT VERSION() AS ver');
        $config  = [
            'url'             => $_SERVER['HTTP_HOST'],////当前请求的 Host: 头部的内容。
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],//当前运行脚本所在的文档根目录
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT'],//服务器所使用的端口
            'server_ip'       => $_SERVER['SERVER_ADDR'],
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],//服务器标识的字串
            'php_version'     => PHP_VERSION,
            'mysql_version'   => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];

        return $this->fetch('index', ['config' => $config]);
    }
    public function info(){
        return $this->fetch();
    }
}
