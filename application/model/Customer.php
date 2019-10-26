<?php
/**
 * Description: 客户/精英类文件.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\model;

use think\Db;

class Customer extends Base
{

    //客服详情
    public function customerdetails($id)
    {
        $module = Db::table('pu_customer')
            ->where('id', $id)
            ->find();
        return $module;
    }

    //查看客服精英是否存在
    public function customisexist($id,$customname,$datatype)
    {
        if ($id) {
            $userdata = Db::table('pu_customer')
                ->where('id!=' . $id)
                ->where('customer_name', $customname)
                ->where('data_type', $datatype)
                ->find();

        } else {
            $userdata = Db::table('pu_customer')
                ->where('customer_name', $customname)
                ->where('data_type', $datatype)
                ->find();
        }
        return $userdata;
    }

    //客服/精英保存
    public function customersave($data)
    {
        $newdata = [
            "customer_name" => $data['customername'],
            "customer_img" => $data['customerimg'],
            "customer_phone" => $data['customerphone'],
            "data_type" => $data['datatype']
        ];
        if ($data['id']) {
            Db::table('pu_customer')
                ->where('id', $data['id'])
                ->update($newdata);
            $id = $data['id'];
        } else {
            Db::table('pu_customer')->insert($newdata);
            $id = Db::name('pu_customer')->getLastInsID();
        }
        return $id;
    }

    //删除客服/精英
    public function delcustomer($delid)
    {
        Db::table('pu_customer')
            ->where('id=' . $delid)
            ->delete();
    }
}
