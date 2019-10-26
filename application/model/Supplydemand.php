<?php

/**
 * Description: 求购求租类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;
use app\common\TypeValueCodes;
use think\Model;
use think\Db;

class Supplydemand extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_supplydemand';
    protected $fillable = [];


    //获取求购求租列表数据信息
    public function supplydemands()
    {
        $data = Db::table('pu_supplydemand')
            ->paginate(20, false, ['query' => request()->param()])->each(function ($item, $key) {
                //供求类型
                $item['type_value'] = TypeValueCodes::get($item['type_value']);
                return $item;
            });
        return $data;
    }

    //求购求租详情数据
    public function supplydetail($id)
    {
        $data = Db::table('pu_supplydemand')
            ->where('id', $id)
            ->find();
        //获取图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,3);
        $data['img_urls']=$imgs;
        foreach ($imgs as $img){
            $data['imgurls'].=$img['img_url'].";";
        }
        return $data;
    }

    //求购求租信息是否存在
    public function supplyisexist($id,$msgtitle)
    {
        if ($id) {
            $data = Db::table('pu_supplydemand')
                ->where('id!=' . $id)
                ->where('msg_title', $msgtitle)
                ->find();

        } else {
            $data = Db::table('pu_supplydemand')
                ->where('msg_title', $msgtitle)
                ->find();
        }
        return $data;
    }

    //求购求租信息保存
    public function supplysave($data)
    {
        $newdata = [
            "msg_title" => $data['msgtitle'],
            "type_value" => $data['typevalue'],
            "acreage_num" => $data['acreagenum'],
            "price_num" => $data['pricenum'],
            "house_type" => $data['housetype'],
            "acreage_scope" => $data['acreagescope'],
            "house_num" => $data['housenum'],
            "msg_info" => $data['msginfo'],
            "link_name" => $data['linkname'],
            "link_phone" => $data['linkphone'],
            "link_address" => $data['linkaddress'],
            "create_time" => time(),
            "user_id" => $data['user_id']?:0
        ];
        if ($data['id']) {
            Db::table('pu_supplydemand')
                ->where('id', $data['id'])
                ->update($newdata);
            $newid = $data['id'];
        } else {
            Db::table('pu_supplydemand')->insert($newdata);
            $newid = Db::name('pu_supplydemand')->getLastInsID();
        }
        $imgurls = trim($data['imgurls'], ";");
        if($imgurls){
            //将图片地址信息保存到数据库中
            Db::table('pu_imgs')
                ->where("data_id", $newid)
                ->where('img_type', 3)
                ->delete();

            $imgurls = explode(";", $imgurls);
            foreach ($imgurls as $url) {
                $imgdata = [
                    'img_url' => $url,
                    'img_type' => 3,
                    'data_id' => $newid
                ];
                Db::table('pu_imgs')->insert($imgdata);
            }
        }
    }

    //删除求租求购信息
    public function delsupply($id)
    {
        Db::table('pu_supplydemand')
            ->where('id=' . $id)
            ->delete();
        //删除图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,3);
        foreach ($imgs as $img){
            $imgModel->delpic($img['id'],$img['img_url']);
        }
    }

}
