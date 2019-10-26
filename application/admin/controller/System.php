<?php
/**
 * Description: 后台数据中系统管理板块相关操作.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;
use app\model\Industrytype;
use app\model\Links;
class System extends Base
{

    /**
     * 行业类型列表
     */
    public function industryTypes($fatherid = 0)
    {
        $industryModel = new Industrytype();
        $industrys = $industryModel->industrylist($fatherid);
        $this->assign('industrys', $industrys);
        $this->assign('fatherid', $fatherid);
        return $this->fetch('industrys');
    }

    /**
     * 添加/编辑行业分类
     * @param int $proid 分类id
     */
    public function addIndustry($typeid = 0, $datatype = 0)
    {
        $industryModel = new Industrytype();
        if ($typeid) {
            //获取编辑的详情数据信息
            $typedetail = $industryModel->industrydetail($typeid, $datatype);
        } else {
            $typedetail = $industryModel->toArray();
        }
        $this->assign("typedetail", $typedetail);
        if ($datatype == 0) {
            //获取一级行业分类数据信息
            $industrys = $industryModel->industrylist();
            $this->assign("industrys", $industrys);
        }
        $this->assign("datatype", $datatype);
        return $this->fetch('addindustry');
    }

    /**
     * 行业分类保存
     */
    public function doAddIndustry()
    {
        $industryModel = new Industrytype();
        //查询项目是否存在
        $data = $industryModel->typeisexist($_POST['id'], $_POST['industryname'], $_POST['datatype']);
        if ($data) {
            $this->error('该分类已经存在，请重新输入', '/admin/system/addIndustry' . ($_POST['datatype'] == 1 ? "/0/" . $_POST['datatype'] : ""));
        } else {
            $industryModel->industrysave($_POST['id'], $_POST['industryname'], $_POST['fatherid'], $_POST['datatype']);
            $this->success('保存成功', $_POST['datatype'] == 0 ? '/admin/system/industry' : '/admin/system/shoptypes/' . $_POST['datatype']);
        }
    }

    /**
     * 删除行业分类
     * @param $typeid 分类id
     */
    public function delIndustry($typeid, $datatype)
    {
        $industryModel = new Industrytype();
        $industryModel->delindustry($typeid, $datatype);
        $this->success('删除成功', $datatype == 0 ? '/admin/system/industry' : '/admin/system/shoptypes');
    }

    /**
     * 商铺/加盟类型列表
     */
    public function shopTypes($datatype = 1)
    {
        $industryModel = new Industrytype();
        $shoptypes = $industryModel->industrylist(0, $datatype);
        $this->assign('industrys', $shoptypes);
        $this->assign('datatype', $datatype);
        return $this->fetch('industrys');
    }


    /**
     * 友情链接列表
     */
    public function links()
    {
        $linkModel = new Links();
        $data = $linkModel->linklist();
        $this->assign('links', $data);
        return $this->fetch('links');
    }

    /**
     * 友情链接详情
     * @param int $linkid
     */
    public function addLink($linkid = 0)
    {
        $linkModel = new Links();
        if ($linkid) {
            //获取编辑的详情数据信息
            $linkdetail = $linkModel->linkdetail($linkid);
        } else {
            $linkdetail = $linkModel->toArray();
        }
        $this->assign("linkdetail", $linkdetail);
        return $this->fetch('addlink');
    }

    /**
     * 友情链接保存
     */
    public function doAddLink()
    {
        $linkModel = new Links();
        //检查是否存在
        $data = $linkModel->linkisexist($_POST['id'], $_POST['linkname']);
        if ($data) {
            $this->error('该友情链接，请重新输入', '/admin/system/addLink');
        } else {
            $linkModel->linksave($_POST['id'], $_POST['linkname'], $_POST['linkurl']);
            $this->success('保存成功','/admin/system/links');
        }
    }

    /**
     * 删除友情链接
     * @param $linkid
     */
    public function delLink($linkid)
    {
        $linkModel = new Links();
        $linkModel->dellink($linkid);
        $this->success('删除成功', '/admin/system/links');
    }


}
