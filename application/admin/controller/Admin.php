<?php
/**
 * Description: 后台管理.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

class Admin extends Base
{
    //首页数据
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 管理员列表数据
     * @return mixed
     */
    public function userList()
    {
        return $this->fetch();
    }

    /**
     * 管理员新增/更新
     * @return mixed
     */
    public function addUser()
    {
        return $this->fetch();
    }

    /**
     * 删除管理员
     */
    public function delUser()
    {

    }
}
