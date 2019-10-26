<?php
/**
 * Description: 二手房交易相关类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;
use app\common\DecorateLevelCodes;
use app\common\TypeValueCodes;
use think\Model;
use think\Db;

class Handhouse extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_handhouse';
    protected $fillable = [];


    //获取二手房列表数据信息
    public function handhouses()
    {
        $data = Db::table('pu_handhouse')
            ->paginate(20, false, ['query' => request()->param()])->each(function ($item, $key) {
                //供求类型
                $item['type_value'] = TypeValueCodes::get($item['type_value']);
                //装修档次
                $item['decorate_level'] = DecorateLevelCodes::get($item['decorate_level']);
                return $item;
            });
        return $data;
    }

    //二手房详情数据
    public function handhousedetail($id)
    {
        $data = Db::table('pu_handhouse')
            ->where('id', $id)
            ->find();
        //获取图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,1);
        $data['img_urls']=$imgs;
        foreach ($imgs as $img){
            $data['imgurls'].=$img['img_url'].";";
        }
        return $data;
    }

    //二手房信息是否存在
    public function handisexist($id,$msgtitle)
    {
        if ($id) {
            $data = Db::table('pu_handhouse')
                ->where('id!=' . $id)
                ->where('msg_title', $msgtitle)
                ->find();

        } else {
            $data = Db::table('pu_handhouse')
                ->where('msg_title', $msgtitle)
                ->find();
        }
        return $data;
    }

    //二手房信息保存
    public function handhousesave($data)
    {
        $newdata = [
            "type_value" => $data['typevalue'],
            "estate_name" => $data['estatename'],
            "house_type" => $data['housetype'],
            "acreage_num" => $data['acreagenum'],
            "decorate_level" => $data['decoratelevel'],
            "orientation" => $data['orientation'],
            "is_certificate" => $data['iscertificate'],
            "price_num" => $data['pricenum'],
            "msg_title" => $data['msgtitle'],
            "acreage_scope" => $data['acreagescope'],
            "price_scope" => ($data['typevalue']==2||$data['typevalue']==4)?$data['pricescope1']:$data['pricescope'],
            "house_num" => $data['housenum'],
            "floor_num" => $data['floornum'],
            "total_floor" => $data['totalfloor'],
            "house_allocation" => $data['houseallocation'],
            "msg_info" => $data['msginfo'],
            "link_name" => $data['linkname'],
            "link_phone" => $data['linkphone'],
            "link_address" => $data['linkaddress'],
            "create_time" => time(),
            "user_id" => $data['user_id']?:0
        ];
        if ($data['id']) {
            Db::table('pu_handhouse')
                ->where('id', $data['id'])
                ->update($newdata);
            $newid = $data['id'];
        } else {
            Db::table('pu_handhouse')->insert($newdata);
            $newid = Db::name('pu_handhouse')->getLastInsID();
        }
        $imgurls = trim($data['imgurls'], ";");
        if($imgurls){
            //将图片地址信息保存到数据库中
            Db::table('pu_imgs')
                ->where("data_id", $newid)
                ->where('img_type', 1)
                ->delete();

            $imgurls = explode(";", $imgurls);
            foreach ($imgurls as $url) {
                $imgdata = [
                    'img_url' => $url,
                    'img_type' => 1,
                    'data_id' => $newid
                ];
                Db::table('pu_imgs')->insert($imgdata);
            }
        }
    }

    //删除二手房信息
    public function delhouse($id)
    {
        Db::table('pu_handhouse')
            ->where('id=' . $id)
            ->delete();
        //删除图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,1);
        foreach ($imgs as $img){
            $imgModel->delpic($img['id'],$img['img_url']);
        }
    }

}
