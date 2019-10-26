<?php
/**
 * Description: 后台数据中业务管理板块相关操作.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

use app\model\Handhouse;
use app\model\Industrytype;
use app\model\Imgs;
use app\model\Joins;
use app\model\Shoptransfer;
use app\model\Supplydemand;
use app\model\Workware;
use QaCommon\DataState\BrandHistoryCodes;
use QaCommon\DataState\DecorateLevelCodes;
use QaCommon\DataState\InvestNumCodes;
use QaCommon\DataState\OrientationCodes;
use QaCommon\DataState\PriceScopeCodes;
use QaCommon\DataState\ScopeCodes;
use QaCommon\DataState\StoreNumCodes;
use QaCommon\DataState\TypeValueCodes;
use QaCommon\DataState\WorkTypeCodes;

class Business extends Base
{

    /**
     * 商铺转让列表
     */
    public function shopTransfer()
    {
        $transferModel=new Shoptransfer();
        $datalist=$transferModel->shoplist();
        $this->assign('data', $datalist);
        return $this->fetch('transfer');
    }


    /**
     * 添加/编辑商铺转让页面
     * @param int $id
     */
    public function addTransfer($id=0)
    {
        $transferModel = new Shoptransfer();
        $industryModel=new Industrytype();
        if ($id) {
            //获取编辑的详情数据信息
            $transferdetail = $transferModel->transferdetail($id);
        } else {
            $transferdetail = $transferModel->toArray();
        }
        $this->assign("transferdetail", $transferdetail);
        //获取行业列表
        $industrys = $industryModel->industrylist(0);
        $this->assign('industrys', $industrys);
        //获取商铺列表
        $shoptype = $industryModel->industrylist(0,1);
        $this->assign('shoptype', $shoptype);

        //供求类型
        $typevalues=TypeValueCodes::$val;
        $this->assign('typevalues', $typevalues);

        //面积范围
        $scopearr=ScopeCodes::$val;
        $this->assign('scopearr', $scopearr);

        return $this->fetch('addtransfer');
    }

    /**
     * 保存商铺转让信息
     */
    public function doAddTransfer()
    {
        $transferModel = new Shoptransfer();
        //查询是否存在
        $data = $transferModel->shopisexist($_POST['id'], $_POST['msgtitle']);
        if ($data) {
            $this->error('该商铺信息已经存在，请重新输入', '/admin/business/addTransfer');
        } else {
            $transferModel->shopsave($_POST);
            $this->success('保存成功', '/admin/business/transfer');
        }
    }

    /**
     * 删除商铺信息
     * @param $id商铺id
     */
    public function delTransfer($id){
        $transferModel = new Shoptransfer();
        $transferModel->deltransfer($id);
        $this->success('删除成功', '/admin/business/transfer');
    }




    /**
     * 二手房列表信息管理
     */
    public function handHouse()
    {
        $handhouseModel = new Handhouse();
        $datalist = $handhouseModel->handhouses();
        $this->assign('data', $datalist);
        return $this->fetch('handhouse');
    }

    /**
     * 获取二手房信息
     * @param int $id
     * @return mixed
     */
    public function addHandhouse($id=0)
    {
        $handhouseModel = new Handhouse();
        if ($id) {
            //获取编辑的详情数据信息
            $handhousedetail = $handhouseModel->handhousedetail($id);
        } else {
            $handhousedetail = $handhouseModel->toArray();
        }
        $this->assign("handhousedetail", $handhousedetail);
        //供求类型
        $typevalues=TypeValueCodes::$val;
        unset($typevalues[0]);
        $this->assign('typevalues', $typevalues);
        //装修档次
        $levelarr=DecorateLevelCodes::$val;
        $this->assign('levelarr', $levelarr);
        //朝向
        $orientation=OrientationCodes::$val;
        $this->assign('orientation', $orientation);
        //面积范围
        $scopearr=ScopeCodes::$val;
        $this->assign('scopearr', $scopearr);
        //价格范围1
        $onescopearr=PriceScopeCodes::$val;
        //价格范围2
        $twoscopearr=PriceScopeCodes::$val2;
        $this->assign('onescopearr', $onescopearr);
        $this->assign('twoscopearr', $twoscopearr);
        return $this->fetch('addhandhouse');
    }

    /**
     * 二手房信息保存
     */
    public function doAddHandhouse()
    {
        $handhouseModel = new Handhouse();
        //查询是否存在
        $data = $handhouseModel->handisexist($_POST['id'], $_POST['msgtitle']);
        if ($data) {
            $this->error('该二手房信息已经存在，请重新输入', '/admin/business/addHandhouse');
        } else {
            $handhouseModel->handhousesave($_POST);
            $this->success('保存成功', '/admin/business/handhouse');
        }
    }

    /**
     * 删除二手房信息
     * @param $id
     */
    public function delHandhouse($id){
        $handhouseModel = new Handhouse();
        $handhouseModel->delhouse($id);
        $this->success('删除成功', '/admin/business/handhouse');
    }





    /**
     * 厂房仓库列表信息
     */
    public function workwareHouse()
    {
        $workModel = new Workware();
        $datalist = $workModel->workwares();
        $this->assign('data', $datalist);
        return $this->fetch('workware');
    }

    /**
     * 获取厂房仓库信息
     * @param int $id
     * @return mixed
     */
    public function addWorkware($id=0)
    {
        $workModel = new Workware();
        if ($id) {
            //获取编辑的详情数据信息
            $workwaredetail = $workModel->workwaredetail($id);
        } else {
            $workwaredetail = $workModel->toArray();
        }
        $this->assign("workwaredetail", $workwaredetail);
        //供求类型
        $typevalues = TypeValueCodes::$val;
        unset($typevalues[0]);
        $this->assign('typevalues', $typevalues);
        //资源类型
        $housetypearr = WorkTypeCodes::$val;
        $this->assign('housetypearr', $housetypearr);
        //面积范围
        $scopearr = ScopeCodes::$val;
        $this->assign('scopearr', $scopearr);

        return $this->fetch('addworkware');
    }

    /**
     * 厂房仓库信息保存
     */
    public function doAddWorkware()
    {
        $workModel = new Workware();
        //查询是否存在
        $data = $workModel->workisexist($_POST['id'], $_POST['msgtitle']);
        if ($data) {
            $this->error('该厂房仓库信息已经存在，请重新输入', '/admin/business/addWorkware');
        } else {
            $workModel->workwaresave($_POST);
            $this->success('保存成功', '/admin/business/workware');
        }
    }

    /**
     * 删除厂房仓库信息
     * @param $id
     */
    public function delWorkware($id){
        $workModel = new Workware();
        $workModel->delworkware($id);
        $this->success('删除成功', '/admin/business/workware');
    }





    /**
     * 求购求租列表信息
     */
    public function supplyDemand()
    {
        $supplyModel = new Supplydemand();
        $datalist = $supplyModel->supplydemands();
        $this->assign('data', $datalist);
        return $this->fetch('supplydemand');
    }

    /**
     * 获取求购求租详情信息
     * @param int $id
     * @return mixed
     */
    public function addSupply($id=0)
    {
        $supplyModel = new Supplydemand();
        if ($id) {
            //获取编辑的详情数据信息
            $supplydetail = $supplyModel->supplydetail($id);
        } else {
            $supplydetail = $supplyModel->toArray();
        }
        $this->assign("supplydetail", $supplydetail);
        //供求类型
        $typevalues = TypeValueCodes::$val;
        unset($typevalues[0]);
        unset($typevalues[1]);
        unset($typevalues[2]);
        $this->assign('typevalues', $typevalues);
        //面积范围
        $scopearr = ScopeCodes::$val;
        $this->assign('scopearr', $scopearr);

        return $this->fetch('addsupply');
    }

    /**
     * 求购求租信息保存
     */
    public function doAddSupply()
    {
        $supplyModel = new Supplydemand();
        //查询是否存在
        $data = $supplyModel->supplyisexist($_POST['id'], $_POST['msgtitle']);
        if ($data) {
            $this->error('求购求租信息已经存在，请重新输入', '/admin/business/addSupply');
        } else {
            $supplyModel->supplysave($_POST);
            $this->success('保存成功', '/admin/business/supplydemand');
        }
    }

    /**
     * 删除求购求租信息
     * @param $id
     */
    public function delSupply($id){
        $supplyModel = new Supplydemand();
        $supplyModel->delsupply($id);
        $this->success('删除成功', '/admin/business/supplydemand');
    }







    /**
     * 招商加盟列表信息
     */
    public function Joins()
    {
        $joinModel = new Joins();
        $datalist = $joinModel->joins();
        $this->assign('data', $datalist);
        return $this->fetch('joins');
    }

    /**
     * 获取招商加盟详情信息
     * @param int $id
     * @return mixed
     */
    public function addJoin($id=0)
    {
        $joinModel = new Joins();
        $industryModel=new Industrytype();
        if ($id) {
            //获取编辑的详情数据信息
            $joindetail = $joinModel->joindetail($id);
        } else {
            $joindetail = $joinModel->toArray();
        }
        $this->assign("joindetail", $joindetail);
        //获取加盟类型
        $industrys = $industryModel->industrylist(0,2);
        $this->assign('industrys', $industrys);
        //获取品牌历史
        $brandarr=BrandHistoryCodes::$val;
        $this->assign('brandarr', $brandarr);
        //获取投资金额
        $investnum=InvestNumCodes::$val;
        $this->assign('investnumarr', $investnum);
        //获取分店范围
        $storearr=StoreNumCodes::$val;
        $this->assign('storearr', $storearr);
        return $this->fetch('addjoin');
    }

    /**
     * 招商加盟信息保存
     */
    public function doAddJoin()
    {
        $joinModel = new Joins();
        //查询是否存在
        $data = $joinModel->joinisexist($_POST['id'], $_POST['msgtitle']);
        if ($data) {
            $this->error('招商加盟信息已经存在，请重新输入', '/admin/business/addJoin');
        } else {
            $joinModel->joinsave($_POST);
            $this->success('保存成功', '/admin/business/joins');
        }
    }

    /**
     * 删除加盟信息
     * @param $id
     */
    public function delJoin($id){
        $joinModel = new Joins();
        $joinModel->deljoin($id);
        $this->success('删除成功', '/admin/business/joins');
    }


    /**
     * 删除图片
     */
    public function delPic()
    {
        $picid = $_POST['id'];
        $imgurl = $_POST['imgurl'];
        $imgModel = new Imgs();
        $imgModel->delpic($picid,$imgurl);
        echo 0;
        exit;
    }

    //上传文件
    public function uploadFiles()
    {
        $imgModel = new Imgs();
        $imgurl = $imgModel->uploadpic($_FILES['file']);
        echo $imgurl;
        exit();
    }

}
