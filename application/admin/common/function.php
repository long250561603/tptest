<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2016/12/8
 * Time: 14:05
 */
function upload($fromType=0){
    $fileKey = key($_FILES);
    $dir = Input('post.dir');
    if($dir=='')return json_encode(['msg'=>'没有指定文件目录！','status'=>-1]);
    $dirs = WSTConf("CONF.wstUploads");
    if(!in_array($dir, $dirs)){
        return json_encode(['msg'=>'非法文件目录！','status'=>-1]);
    }
    // 上传文件
    $file = request()->file($fileKey);
    if($file===null){
        return json_encode(['msg'=>'上传文件不存在或超过服务器限制','status'=>-1]);
    }
    $validate = new \think\Validate([
        ['fileMime','fileMime:image/png,image/gif,image/jpeg,image/x-ms-bmp','只允许上传jpg,gif,png,bmp类型的文件'],
        ['fileExt','fileExt:jpg,jpeg,gif,png,bmp','只允许上传后缀为jpg,gif,png,bmp的文件'],
        ['fileSize','fileSize:2097152','文件大小超出限制'],//最大2M
    ]);
    $data = ['fileMime'  => $file,
        'fileSize' => $file,
        'fileExt'=> $file
    ];
    if (!$validate->check($data)) {
        return json_encode(['msg'=>$validate->getError(),'status'=>-1]);
    }
    $info = $file->rule('uniqid')->move(ROOT_PATH.'/upload/'.$dir."/".date('Y-m'));
    if($info){
        $filePath = $info->getPathname();
        $filePath = str_replace(ROOT_PATH,'',$filePath);
        $filePath = str_replace('\\','/',$filePath);
        $name = $info->getFilename();
        $filePath = str_replace($name,'',$filePath);
        //原图路径
        $imageSrc = trim($filePath.$name,'/');
        //图片记录
        WSTRecordImages($imageSrc, (int)$fromType);
        //打开原图
        $image = \image\Image::open($imageSrc);
        //缩略图路径 手机版原图路径 手机版缩略图路径
        $thumbSrc = $mSrc = $mThumb = null;
        //手机版原图宽高
        $mWidth = min($image->width(),(int)input('mWidth',700));
        $mHeight = min($image->height(),(int)input('mHeight',700));
        //手机版缩略图宽高
        $mTWidth = min($image->width(),(int)input('mTWidth',250));
        $mTHeight = min($image->height(),(int)input('mTHeight',250));

        /****************************** 生成缩略图 *********************************/
        $isThumb = (int)input('isThumb');
        if($isThumb==1){
            //缩略图路径
            $thumbSrc = str_replace('.', '_thumb.', $imageSrc);
            $image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
            //是否需要生成移动版的缩略图
            $suffix = WSTConf("CONF.wstMobileImgSuffix");
            if(!empty($suffix)){
                $image = \image\Image::open($imageSrc);
                $mSrc = str_replace('.',"$suffix.",$imageSrc);
                $mThumb = str_replace('.', '_thumb.',$mSrc);
                $image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
                $image->thumb($mTWidth, $mTHeight, 2)->save($mThumb,$image->type(),90);
            }


        }
        /***************************** 添加水印 ***********************************/
        $isWatermark=(int)input('isWatermark');
        if($isWatermark==1 && (int)WSTConf('CONF.watermarkPosition')!==0){
            //取出水印配置
            $wmWord = WSTConf('CONF.watermarkWord');//文字
            $wmFile = trim(WSTConf('CONF.watermarkFile'),'/');//水印文件
            $wmPosition = (int)WSTConf('CONF.watermarkPosition');//水印位置
            $wmSize = ((int)WSTConf('CONF.watermarkSize')!=0)?WSTConf('CONF.watermarkSize'):'20';//大小
            $wmColor = (WSTConf('CONF.watermarkColor')!='')?WSTConf('CONF.watermarkColor'):'#000000';//颜色必须是16进制的
            $wmOpacity = ((int)WSTConf('CONF.watermarkOpacity')!=0)?WSTConf('CONF.watermarkOpacity'):'100';//水印透明度
            //是否有自定义字体文件
            $customTtf = $_SERVER['DOCUMENT_ROOT'].WSTConf('CONF.watermarkTtf');
            $ttf = is_file($customTtf)?$customTtf:EXTEND_PATH.'/verify/verify/ttfs/3.ttf';
            $image = \image\Image::open($imageSrc);
            if(!empty($wmWord)){//当设置了文字水印 就一定会执行文字水印,不管是否设置了文件水印

                //执行文字水印
                $image->text($wmWord, $ttf, $wmSize, $wmColor, $wmPosition)->save($imageSrc);
                if($thumbSrc!==null){
                    $image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
                }
                //如果有生成手机版原图
                if(!empty($mSrc)){
                    $image = \image\Image::open($imageSrc);
                    $image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
                    $image->thumb($mTWidth, $mTHeight, 2)->save($mThumb,$image->type(),90);
                }
            }elseif(!empty($wmFile)){//设置了文件水印,并且没有设置文字水印
                //执行图片水印
                $image->water($wmFile, $wmPosition, $wmOpacity)->save($imageSrc);
                if($thumbSrc!==null){
                    $image->thumb((int)input('width',min(300,$image->width())), (int)input('height',min(300,$image->height())),2)->save($thumbSrc,$image->type(),90);
                }
                //如果有生成手机版原图
                if($mSrc!==null){
                    $image = \image\Image::open($imageSrc);
                    $image->thumb($mWidth, $mHeight)->save($mSrc,$image->type(),90);
                    $image->thumb($mTWidth, $mTHeight,2)->save($mThumb,$image->type(),90);
                }
            }
        }
        //判断是否有生成缩略图
        $thumbSrc = ($thumbSrc==null)?$info->getFilename():str_replace('.','_thumb.', $info->getFilename());
        $filePath = ltrim($filePath,'/');
        // 用户头像上传宽高限制
        $isCut = (int)input('isCut');
        if($isCut){
            $imgSrc = $filePath.$info->getFilename();
            $image = \image\Image::open($imgSrc);
            $size = $image->size();//原图宽高
            $w = $size[0];
            $h = $size[1];
            $rate = $w/$h;
            if($w>$h && $w>500){
                $newH = 500/$rate;
                $image->thumb(500, $newH)->save($imgSrc,$image->type(),90);
            }elseif($h>$w && $h>500){
                $newW = 500*$rate;
                $image->thumb($newW, 500)->save($imgSrc,$image->type(),90);
            }
        }
        return json_encode(['status'=>1,'savePath'=>$filePath,'name'=>$info->getFilename(),'thumb'=>$thumbSrc]);
    }else{
        //上传失败获取错误信息
        return $file->getError();
    }
}