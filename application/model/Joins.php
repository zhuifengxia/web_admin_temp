<?php

/**
 * Description: 招商加盟类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;
use think\Model;
use think\Db;

class Joins extends Base
{
    protected $pk = 'id';
    protected $table = 'pu_join';
    protected $fillable = [];


    //获取招商加盟列表数据信息
    public function joins()
    {
        $data = Db::table('pu_join')
            ->paginate(20, false, ['query' => request()->param()])->each(function ($item, $key) {
                //加盟类型
                $data = Db::table('pu_industrytype')
                    ->field('industry_name')
                    ->where("id", $item['join_type'])
                    ->where("data_type", 2)
                    ->find();
                $item['join_type'] = $data['industry_name'];
                return $item;
            });
        return $data;
    }

    //招商加盟详情数据
    public function joindetail($id)
    {
        $data = Db::table('pu_join')
            ->where('id', $id)
            ->find();
        //获取图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,4);
        $data['img_urls']=$imgs;
        foreach ($imgs as $img){
            $data['imgurls'].=$img['img_url'].";";
        }
        return $data;
    }

    //求招商加盟是否存在
    public function joinisexist($id,$msgtitle)
    {
        if ($id) {
            $data = Db::table('pu_join')
                ->where('id!=' . $id)
                ->where('msg_title', $msgtitle)
                ->find();

        } else {
            $data = Db::table('pu_join')
                ->where('msg_title', $msgtitle)
                ->find();
        }
        return $data;
    }

    //招商加盟信息保存
    public function joinsave($data)
    {
        $newdata = [
            "join_type" => $data['jointype'],
            "brand_name" => $data['brandname'],
            "brand_history" => $data['brandhistory'],
            "invest_num" => $data['investnum'],
            "store_num" => $data['storenum'],
            "house_num" => $data['housenum'],
            "join_money" => $data['joinmoney'],
            "msg_title" => $data['msgtitle'],
            "company_url" => $data['companyurl'],
            "msg_info" => $data['msginfo'],
            "link_name" => $data['linkname'],
            "link_phone" => $data['linkphone'],
            "link_address" => $data['linkaddress'],
            "create_time" => time(),
            "user_id" => $data['user_id']?:0
        ];
        if ($data['id']) {
            Db::table('pu_join')
                ->where('id', $data['id'])
                ->update($newdata);
            $newid = $data['id'];
        } else {
            Db::table('pu_join')->insert($newdata);
            $newid = Db::name('pu_join')->getLastInsID();
        }
        $imgurls = trim($data['imgurls'], ";");
        if($imgurls){
            //将图片地址信息保存到数据库中
            Db::table('pu_imgs')
                ->where("data_id", $newid)
                ->where('img_type', 4)
                ->delete();

            $imgurls = explode(";", $imgurls);
            foreach ($imgurls as $url) {
                $imgdata = [
                    'img_url' => $url,
                    'img_type' => 4,
                    'data_id' => $newid
                ];
                Db::table('pu_imgs')->insert($imgdata);
            }
        }
    }

    //删除招商加盟信息
    public function deljoin($id)
    {
        Db::table('pu_join')
            ->where('id=' . $id)
            ->delete();
        //删除图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,4);
        foreach ($imgs as $img){
            $imgModel->delpic($img['id'],$img['img_url']);
        }
    }

}
