<?php

/**
 * Description: 厂房仓库类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\model;
use app\common\TypeValueCodes;
use app\common\WorkTypeCodes;
use think\Model;
use think\Db;

class Workware extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_workwarehouse';
    protected $fillable = [];


    //获取厂房仓库列表数据信息
    public function workwares()
    {
        $data = Db::table('pu_workwarehouse')
            ->paginate(20, false, ['query' => request()->param()])->each(function ($item, $key) {
                //供求类型
                $item['type_value'] = TypeValueCodes::get($item['type_value']);
                //资源类型
                $item['house_type'] = WorkTypeCodes::get($item['house_type']);
                return $item;
            });
        return $data;
    }

    //厂房仓库详情数据
    public function workwaredetail($id)
    {
        $data = Db::table('pu_workwarehouse')
            ->where('id', $id)
            ->find();
        //获取图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,2);
        $data['img_urls']=$imgs;
        foreach ($imgs as $img){
            $data['imgurls'].=$img['img_url'].";";
        }
        return $data;
    }

    //厂房仓库信息是否存在
    public function workisexist($id,$msgtitle)
    {
        if ($id) {
            $data = Db::table('pu_workwarehouse')
                ->where('id!=' . $id)
                ->where('msg_title', $msgtitle)
                ->find();

        } else {
            $data = Db::table('pu_workwarehouse')
                ->where('msg_title', $msgtitle)
                ->find();
        }
        return $data;
    }

    //厂房仓库信息保存
    public function workwaresave($data)
    {
        $newdata = [
            "msg_title" => $data['msgtitle'],
            "type_value" => $data['typevalue'],
            "price_num" => $data['pricenum'],
            "acreage_num" => $data['acreagenum'],
            "acreage_scope" => $data['acreagescope'],
            "house_num" => $data['housenum'],
            "house_type" => $data['housetype'],
            "house_type" => $data['housetype'],
            "near_msg" => $data['nearmsg'],
            "msg_info" => $data['msginfo'],
            "link_name" => $data['linkname'],
            "link_phone" => $data['linkphone'],
            "link_address" => $data['linkaddress'],
            "create_time" => time(),
            "user_id" => $data['user_id']?:0
        ];
        if ($data['id']) {
            Db::table('pu_workwarehouse')
                ->where('id', $data['id'])
                ->update($newdata);
            $newid = $data['id'];
        } else {
            Db::table('pu_workwarehouse')->insert($newdata);
            $newid = Db::name('pu_workwarehouse')->getLastInsID();
        }
        $imgurls = trim($data['imgurls'], ";");
        if($imgurls){
            //将图片地址信息保存到数据库中
            Db::table('pu_imgs')
                ->where("data_id", $newid)
                ->where('img_type', 2)
                ->delete();

            $imgurls = explode(";", $imgurls);
            foreach ($imgurls as $url) {
                $imgdata = [
                    'img_url' => $url,
                    'img_type' => 2,
                    'data_id' => $newid
                ];
                Db::table('pu_imgs')->insert($imgdata);
            }
        }
    }

    //删除厂房仓库信息
    public function delworkware($id)
    {
        Db::table('pu_workwarehouse')
            ->where('id=' . $id)
            ->delete();
        //删除图片信息
        $imgModel=new Imgs();
        $imgs=$imgModel->imgurls($id,2);
        foreach ($imgs as $img){
            $imgModel->delpic($img['id'],$img['img_url']);
        }
    }

}
