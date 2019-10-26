<?php
/**
 * Description: 类文件基类.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\common\model;

use think\Model;

class Base extends Model
{
    /**
     * 获取列表数据
     * @param $className 操作类
     * @param array $where 查询条件
     * @param int $paginate 0不分页；1分页
     * @param string $order 排序方式，默认id desc
     * @return mixed
     */
    public function dataList($className,$where=[],$paginate=0,$order="id desc")
    {
        $data = $className::where('is_logic_del', 0)
            ->where($where)
            ->order($order);
        if ($paginate) {
            $resultdata = $data->paginate(20);
        } else {
            $resultdata = $data->select();
        }
        return $resultdata;
    }

    /**
     * 详情数据
     * @param $className 操作类
     * @param $where 查询条件
     * @return mixed
     */
    public function oneDetail($className,$where)
    {
        $data = $className::where('is_logic_del', 0)
            ->where($where)
            ->findOrEmpty();
        return $data;
    }

    /**
     * 数据总数
     * @param $className 操作类
     * @param array $where 查询条件
     * @return 总数
     */
    public function dataCount($className,$where=[])
    {
        $data = $className::where('is_logic_del', 0)
            ->where($where)
            ->count();
        return $data;
    }

    /**
     * 某个字段数据集合。一般查id集合
     * @param $className 操作类
     * @param $fieldName 字段名称
     * @param array $where 查询条件
     * @return mixed 数据集合
     */
    public function dataIDs($className,$fieldName,$where=[])
    {
        $data = $className::where('is_logic_del', 0)
            ->where($where)
            ->column($fieldName);
        return $data;
    }

    /**
     * 更新数据
     * @param $className 操作类
     * @param $data 更新数据集合
     * @param $where 查询条件
     */
    public function updateOne($className,$data,$where)
    {
        $className::where($where)
            ->update($data);
    }

    /**
     * 新增数据
     * @param $className 操作类
     * @param $data 新增数据集合
     * @return $id 新增数据id
     */
    public function addOne($className,$data)
    {
        $id = $className::where('1=1')
            ->insertGetId($data);
        return $id;
    }

    /**
     * 删除数据
     * @param $className 操作类
     * @param $where 查询条件
     */
    public function deleteOne($className,$where)
    {
        $className::where($where)
            ->delete();
    }

    /**
     * 数据自增
     * @param $className 操作类
     * @param $where 查询条件
     * @param $fieldName 自增字段名
     * @param int $num 自增数量 默认1
     */
    public function dataInc($className,$where,$fieldName,$num=1)
    {
        $className::where($where)
            ->setInc($fieldName, $num);
    }

    /**
     * 数据自减
     * @param $className 操作类
     * @param $where 查询条件
     * @param $fieldName 自减字段名
     * @param int $num 自减数量 默认1
     */
    public function dataDec($className,$where,$fieldName,$num=1)
    {
        $className::where($where)
            ->setDec($fieldName, $num);
    }
}
