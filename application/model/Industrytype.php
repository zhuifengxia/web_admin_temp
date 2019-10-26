<?php

/**
 * Description: 商铺类型类文件
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\model;

use think\Model;
use think\Db;

class Industrytype extends Model
{
    protected $pk = 'id';
    protected $table = 'pu_industrytype';
    protected $fillable = [];

    /**
     * 行业列表数据信息
     */
    public function industrylist($fatherid=0,$datatype=0)
    {
        $data = Db::table('pu_industrytype')
            ->where("fatherid",$fatherid)
            ->where("data_type",$datatype)
            ->select();
        return $data;
    }

    /**
     * 行业详情数据信息
     */
    public function industrydetail($typeid,$datatype=0)
    {
        $data = Db::table('pu_industrytype')
            ->where("id", $typeid)
            ->where("data_type",$datatype)
            ->find();
        return $data;
    }

    /**
     * 查询行业分类是否存在
     * @param $id 行业id
     * @param $typename 行业名称
     * @return array|false|\PDOStatement|string|Model
     */
    public function typeisexist($id,$typename,$datatype)
    {
        if ($id) {
            $industry = Db::table('pu_industrytype')
                ->where('id!=' . $id)
                ->where('industry_name', $typename)
                ->where('data_type', $datatype)
                ->find();

        } else {
            $industry = Db::table('pu_industrytype')
                ->where('industry_name', $typename)
                ->where('data_type', $datatype)
                ->find();
        }
        return $industry;
    }

    /**
     * 行业分类保存
     */
    public function industrysave($id,$typename,$fatherid,$datatype)
    {
        $newdata = [
            "industry_name" => $typename,
            "fatherid" => $fatherid?$fatherid:0,
            "data_type" => $datatype
        ];
        if ($id) {
            Db::table('pu_industrytype')
                ->where('id', $id)
                ->update($newdata);
        } else {
            Db::table('pu_industrytype')->insert($newdata);
            $id = Db::name('pu_industrytype')->getLastInsID();
        }
        return $id;
    }

    /**
     * 删除行业分类
     * @param $id
     */
    public function delindustry($id,$datatype)
    {
        Db::table('pu_industrytype')
            ->where('id=' . $id)
            ->where('data_type', $datatype)
            ->delete();
    }
}
