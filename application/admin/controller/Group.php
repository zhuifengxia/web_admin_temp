<?php
/**
 * Description: 后台管理组相关.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

use app\common\model\Group as GroupModel;

class Group extends Base
{
    /**
     * 管理组列表数据
     */
    public function groupList()
    {
        $data = parent::$dataModel->dataList(GroupModel::class);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 新增/更新管理组
     */
    public function groupAdd($id=0)
    {
        $groupModel = new GroupModel();
        $data = $groupModel->oneDetail(GroupModel::class, ['id' => $id]);
        $this->assign('data', $data);
        return $this->fetch();
    }
}
