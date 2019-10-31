<?php
/**
 * Description: 后台管理组相关.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

use app\common\model\Group as GroupModel;
use app\common\model\GroupRules;
use app\common\model\Rules;
use MoCommon\Support\Tree;
use think\Request;

class Group extends Base
{
    /**
     * 管理组列表数据
     */
    public function groupList()
    {
        $groupModel = new GroupModel();
        $data = $groupModel->dataList(GroupModel::class);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 新增/更新管理组
     */
    public function groupAdd(Request $request)
    {
        $groupModel = new GroupModel();
        if ($request->isPost()) {
            $postdata = $request->post();
            $where = [
                ['group_name', '=', $postdata['group_name']]
            ];
            if ($postdata['id']) {
                $where[] = ['id', '<>', $postdata['id']];
            }
            $data = $groupModel->oneDetail(GroupModel::class, $where);
            if (empty($data)) {
                if ($postdata['id']) {
                    $groupModel->updateOne(GroupModel::class, $postdata, ['id' => $postdata['id']]);
                } else {
                    $groupModel->addOne(GroupModel::class, $postdata);
                }
                return json(['code' => 0, 'msg' => '保存成功']);
            } else {
                //已经有这个管理组了
                return json(['code' => 1, 'msg' => '已经有此管理组了，请重新输入']);
            }
        } else {
            $id = input('id', 0);
            if ($id) {
                $data = $groupModel->oneDetail(GroupModel::class, ['id' => $id]);
            } else {
                $data = $groupModel;
            }
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除管理组
     */
    public function groupDel($id)
    {
        $groupModel = new GroupModel();
        $groupModel->updateOne(GroupModel::class, ['is_logic_del' => 1], ['id' => $id]);
        return $this->redirect('/admin/group/list');
    }

    /**
     * 管理组权限
     */
    public function groupRoute($id)
    {
        $groupModel = new GroupModel();
        $group = $groupModel->oneDetail(GroupModel::class, ['id' => $id]);
        //获取当前管理组的权限信息
        $ruleids = $groupModel->dataIDs(GroupRules::class, 'rule_id', ['group_id' => $id]);
        $rules = $groupModel->dataList(Rules::class);
        $rules = Tree::TreeList($rules);
        $group['rules'] = $rules;
        $group['group_rules'] = $ruleids;
        $this->assign('group', $group);
        return $this->fetch();
    }
}
