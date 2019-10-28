<?php
/**
 * Description: 后台路由相关.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

use app\common\model\Rules;
use think\Request;

class Rule extends Base
{
    /**
     * 路由列表数据
     */
    public function ruleList()
    {
        $ruleModel = new Rules();
        $data = $ruleModel->dataList(Rules::class);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 新增/更新路由信息
     */
    public function ruleAdd(Request $request)
    {
        $ruleModel = new Rules();
        if ($request->isPost()) {
            $postdata = $request->post();
            $where = [
                ['rule_name', '=', $postdata['rule_name']],
                ['rule_str', '=', $postdata['rule_str']],
                ['pid', '=', $postdata['pid']]
            ];
            if ($postdata['id']) {
                $where[] = ['id', '<>', $postdata['id']];
            }
            $data = $ruleModel->oneDetail(Rules::class, $where);
            if (empty($data)) {
                if ($postdata['id']) {
                    $ruleModel->updateOne(Rules::class, $postdata, ['id' => $postdata['id']]);
                } else {
                    $ruleModel->addOne(Rules::class, $postdata);
                }
                return json(['code' => 0, 'msg' => '保存成功']);
            } else {
                //已经有这个路由了
                return json(['code' => 1, 'msg' => '已经有此路由了，请重新输入']);
            }
        } else {
            $id = input('id', 0);
            if ($id) {
                $data = $ruleModel->oneDetail(Rules::class, ['id' => $id]);
            } else {
                $data = $ruleModel;
            }
            //获取一级路由
            $rootrule = $ruleModel->dataList(Rules::class, ['pid' => 0]);
            $this->assign('rootrule', $rootrule);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * 删除路由信息
     */
    public function ruleDel($id)
    {
        $ruleModel = new Rules();
        $ruleModel->updateOne(Rules::class, ['is_logic_del' => 1], ['id' => $id]);
        return $this->redirect('/admin/rule/list');
    }
}
