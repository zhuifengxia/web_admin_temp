<?php
/**
 * Description: 商铺转让类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;
use app\common\TypeValueCodes;
use think\Model;
use think\Db;
class Shoptransfer extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_shoptransfer';
    protected $fillable = [];


    //获取商铺转让列表数据
    public function shoplist()
    {
        $data = Db::table('pu_shoptransfer')
            ->paginate(20, false, ['query' => request()->param()])->each(function ($item, $key) {
                //供求类型
                $item['type_value'] = TypeValueCodes::get($item['type_value']);
                //行业类型
                $data = Db::table('pu_industrytype')
                    ->field('industry_name')
                    ->where("id", $item['industry_type'])
                    ->where("data_type", 0)
                    ->find();
                $item['industry_type'] = $data['industry_name'];
                //商铺类型
                $data = Db::table('pu_industrytype')
                    ->field('industry_name')
                    ->where("id", $item['shop_type'])
                    ->where("data_type", 1)
                    ->find();
                $item['shop_type'] = $data['industry_name'];
                return $item;
            });
        return $data;
    }

    //商铺转让详情
    public function transferdetail($id)
    {
        $data = Db::table('pu_shoptransfer')
            ->where('id', $id)
            ->find();
        //获取图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,0);
        $data['img_urls']=$imgs;
        foreach ($imgs as $img){
            $data['imgurls'].=$img['img_url'].";";
        }
        return $data;
    }

    //商铺否存在
    public function shopisexist($id,$msgtitle)
    {
        if ($id) {
            $data = Db::table('pu_shoptransfer')
                ->where('id!=' . $id)
                ->where('msg_title', $msgtitle)
                ->find();

        } else {
            $data = Db::table('pu_shoptransfer')
                ->where('msg_title', $msgtitle)
                ->find();
        }
        return $data;
    }

    //商铺信息保存
    public function shopsave($data)
    {
        $newdata = [
            "industry_type" => $data['industrytype'],
            "msg_title" => $data['msgtitle'],
            "type_value" => $data['typevalue'],
            "house_num" => $data['housenum'],
            "acreage_scope" => $data['acreagescope'],
            "acreage_num" => $data['acreagenum'],
            "transfer_fee" => $data['transferfee'],
            "price_num" => $data['pricenum'],
            "shop_type" => $data['shoptype'],
            "history_operate" => $data['historyoperate'],
            "near_msg" => $data['nearmsg'],
            "msg_info" => $data['msginfo'],
            "link_name" => $data['linkname'],
            "link_phone" => $data['linkphone'],
            "link_address" => $data['linkaddress'],
            "create_time" => time(),
            "user_id" => $data['user_id']?:0
        ];
        if ($data['id']) {
            Db::table('pu_shoptransfer')
                ->where('id', $data['id'])
                ->update($newdata);
            $newid = $data['id'];
        } else {
            Db::table('pu_shoptransfer')->insert($newdata);
            $newid = Db::name('pu_shoptransfer')->getLastInsID();
        }
        $imgurls = trim($data['imgurls'], ";");
        if($imgurls){
            //将图片地址信息保存到数据库中
            Db::table('pu_imgs')
                ->where("data_id", $newid)
                ->where('img_type', 0)
                ->delete();
            $imgurls = explode(";", $imgurls);
            foreach ($imgurls as $url) {
                $imgdata = [
                    'img_url' => $url,
                    'img_type' => 0,
                    'data_id' => $newid
                ];
                Db::table('pu_imgs')->insert($imgdata);
            }
        }

    }

    //删除商铺信息
    public function deltransfer($id)
    {
        Db::table('pu_shoptransfer')
            ->where('id=' . $id)
            ->delete();
        //删除图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,0);
        foreach ($imgs as $img){
            $imgModel->delpic($img['id'],$img['img_url']);
        }
    }
}
