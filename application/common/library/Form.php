<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace common\library;

use think\Controller;
use think\Request;

/**
 * 表单管理控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Form extends Controller
{
    // 定义form字符串
    protected $form = '';

    /**
     * title及页面表单控制器
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function title($title)
    {

        $this->assign('title',$title);
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);
        $this->form = $this->form.$this->fetch('common@form/body');
        return $this;
    }

    /**
     * text表单控制器
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function text($title,$option='',$data,$name,$placeholder,$class = 'form-control')
    {
        $this->assign('title',$title);
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);
        $this->form = $this->form.$this->fetch('common@form/text');
        return $this;
    }

    /**
     * textarea表单控制器
     * @author  矢志bu渝
     */
    public function textarea($title,$option,$data,$name,$placeholder,$class = 'form-control')
    {
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/textarea');       
        return $this;
    }

    /**
     * checkbox表单控制器
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function checkbox($title,$option,$data,$name,$placeholder,$class = '')
    {                
        
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/checkbox');       
        return $this;
    }

    /**
     * select表单控制器
     * @author  矢志bu渝
     */
    public function select($title,$option,$data,$name,$placeholder,$class = '')
    {
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/select');       
        return $this;
    }

    /**
     * radio表单控制器
     * @author  矢志bu渝
     */
    public function radio($title,$option,$data,$name,$placeholder,$class = '')
    {
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/radio');       
        return $this;
    }

    /**
     * 图片上传表单控制器
     * @author  矢志bu渝
     */
    public function picture($title,$option,$data,$name,$placeholder,$class = '')
    {
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/picture');       
        return $this;
    }

    /**
     * 文件上传表单控制器
     * @author  矢志bu渝
     */
    public function file($title,$option,$data,$name,$placeholder,$class = '')
    {
        $this->assign('title',$title);
        $this->assign('option',$option);          
        $this->assign('data',$data);
        $this->assign('name',$name);
        $this->assign('placeholder',$placeholder);
        $this->assign('class',$class);

        $this->form = $this->form.$this->fetch('common@form/file');
        return $this;
    }

    /**
     * renderhtml表单控制器
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function renderhtml($template = '',$title = '')
    {
        if (empty($template) && empty($title)) {
            return $this->form;
        } else {
            $arr = explode('|', $title);
            $this->assign('bigTitle',$arr[0]);
            $this->assign('smallTitle',$arr[1]);
            $this->assign('form',$this->form);
            return $this->fetch('common@form/'.$template);
        }
    }
}


