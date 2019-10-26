<?php

/**
 * Description: 后台用户管理相关操作.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\admin\controller;

class Users extends Base
{
    /**
     * 管理员列表
     */
    public function userList()
    {
        $customerModel = new Users();
        $customers=$customerModel->dataList();
        $this->assign('customers', $customers);
        return $this->fetch('customers');
    }

    /**
     * 添加/编辑客服
     * @param int $proid 分类id
     */
    public function addCustomer($id=0)
    {
        $customerModel = new Users();
        if ($id) {
            //获取编辑的详情数据信息
            $customdetail = $customerModel->customerdetails($id);
        } else {
            $customdetail = $customerModel->toArray();
        }
        $this->assign("customdetail", $customdetail);
        return $this->fetch('addcustomer');
    }

    /**
     * 客服信息保存
     */
    public function doAddCustomer()
    {
        $customerModel = new Users();
        //是否存在
        $data = $customerModel->customisexist($_POST['id'], $_POST['customername'], $_POST['datatype']);
        if ($data) {
            $this->error('已经存在，请重新输入', '/admin/users/addCustomer');
        } else {
            $customerModel->customersave($_POST);
            $this->success('保存成功', '/admin/users/customers');
        }
    }

    /**
     * 删除客服
     * @param $id 客服id
     */
    public function delCustomer($id)
    {
        $customerModel = new Users();
        $customerModel->delcustomer($id);
        $this->success('删除成功', '/admin/users/customers');
    }
}
