<?php

/**
 * Description: 图片相关类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;

use app\common\Helper;
use think\Model;
use think\Db;

class Imgs extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_imgs';
    protected $fillable = [];


    //获取图片列表数据
    public function imgurls($dataid,$imgtype=0)
    {
        $imgs=Db::table('pu_imgs')
            ->where('img_type',$imgtype)
            ->where('data_id',$dataid)
            ->select();
        return $imgs;
    }

    //上传图片
    public function uploadpic($imgfile)
    {
        $imgurl = "";
        //定义可以上传的文件类型
        $typelist = array("image/gif", "image/jpg", "image/jpeg", "image/png");
        if (is_uploaded_file($imgfile['tmp_name']) && in_array($imgfile['type'], $typelist)) {
            //获取文件扩展名
            $exten_name = pathinfo($imgfile['name'], PATHINFO_EXTENSION);
            //重新命名图片名称
            $picname=Helper::custom_mt_uniqid(). "." . $exten_name;//重新命名文件名
            $fpath = ROOT_PATH . "public/uploadfiles/" . date('Ymd') . "/";
            //路径是否存在，不存在则创建
            if (!is_dir($fpath)) {
                mkdir($fpath, 0777);
            }
            //调用move_uploaded_file（）函数，进行文件转移
            $path = $fpath . $picname;
            if (move_uploaded_file($imgfile['tmp_name'], $path)) {
                $imgurl = "/uploadfiles/" . date('Ymd') . "/" . $picname;
            }
        }
        return $imgurl;
    }

    //删除图片信息
    public function delpic($picid,$imgurl)
    {
        //删除数据库中数据
        Db::table('pu_imgs')
            ->where('id', $picid)
            ->delete();
        //删除图片文件
        if(file_exists(ROOT_PATH."public".$imgurl)){
            unlink(ROOT_PATH."public".$imgurl);
        }
    }
}
