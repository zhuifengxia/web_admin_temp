<?php

/**
 * Description: 友情链接类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;

use think\Model;
use think\Db;

class Links extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_links';
    protected $fillable = [];


    //获取友情链接列表
    public function linklist()
    {
        $data = Db::table('pu_links')
            ->select();
        return $data;
    }

    //链接详情
    public function linkdetail($linkid)
    {
        $data = Db::table('pu_links')
            ->where('id', $linkid)
            ->find();
        return $data;
    }

    //链接是否存在
    public function linkisexist($linkid,$linkname)
    {
        if ($linkid) {
            $data = Db::table('pu_links')
                ->where('id!=' . $linkid)
                ->where('link_name', $linkname)
                ->find();

        } else {
            $data = Db::table('pu_links')
                ->where('link_name', $linkname)
                ->find();
        }
        return $data;
    }

    //友情链接保存
    public function linksave($linkid,$linkname,$linkurl)
    {
        $newdata = [
            "link_name" => $linkname,
            "link_url" => $linkurl
        ];
        if ($linkid) {
            Db::table('pu_links')
                ->where('id', $linkid)
                ->update($newdata);
        } else {
            Db::table('pu_links')->insert($newdata);
            $linkid = Db::name('pu_links')->getLastInsID();
        }
        return $linkid;
    }

    //删除友情链接
    public function dellink($linkid)
    {
        Db::table('pu_links')
            ->where('id=' . $linkid)
            ->delete();
    }
}
