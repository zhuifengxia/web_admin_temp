<?php

/**
 * Description: 后台用户管理相关操作.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\admin\controller;

use app\common\model\Admin;
use app\common\model\Group;
use MoCommon\Support\Helper;
use think\Request;

class Users extends Base
{

    /**
     * 管理员列表数据
     * @return mixed
     */
    public function userList()
    {
        $userModel = new Admin();
        $data = $userModel->dataList(Admin::class);
        for ($i = 0; $i < count($data); $i++) {
            $group = $userModel->oneDetail(Group::class, ['id' => $data[$i]['group_id']]);
            $data[$i]['group_name'] = $group['group_name'];
        }
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * 管理员新增/更新
     * @return mixed
     */
    public function userAdd(Request $request)
    {
        $userModel = new Admin();
        if ($request->isPost()) {
            $postdata = $request->post();
            $where = [
                ['user_name', '=', $postdata['user_name']],
                ['group_id', '=', $postdata['group_id']]
            ];
            if ($postdata['id']) {
                $where[] = ['id', '<>', $postdata['id']];
            }
            $data = $userModel->oneDetail(Admin::class, $where);
            if (empty($data)) {
                if($postdata['user_pwd']){
                    $postdata['user_pwd'] = Helper::make_password($postdata['user_pwd'], 'admin');
                }else{
                    unset($postdata['user_pwd']);
                }
                if ($postdata['id']) {
                    $userModel->updateOne(Admin::class, $postdata, ['id' => $postdata['id']]);
                } else {
                    $userModel->addOne(Admin::class, $postdata);
                }
                return json(['code' => 0, 'msg' => '保存成功']);
            } else {
                //已经有这个管理员了
                return json(['code' => 1, 'msg' => '已经有此管理员了，请重新输入']);
            }
        } else {
            $id = input('id', 0);
            if ($id) {
                $data = $userModel->oneDetail(Admin::class, ['id' => $id]);
            } else {
                $data = $userModel;
            }
            //获取管理组列表数据
            $group = $userModel->dataList(Group::class);
            $this->assign('group', $group);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除管理员
     */
    public function userDel($id)
    {
        $userModel = new Admin();
        $userModel->updateOne(Admin::class, ['is_logic_del' => 1], ['id' => $id]);
        return $this->redirect('/admin/user/list');
    }
}
