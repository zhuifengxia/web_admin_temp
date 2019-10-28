<?php
/**
 * Description: 后台控制器基类.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */

namespace app\admin\controller;

use think\Controller;
use think\facade\Hook;

class Base extends Controller
{
    public function initialize()
    {
        parent::initialize();
        //验证登陆
        Hook::listen('admin_check');
        #渲染面包屑
        $this->setCrumbs();
    }

    #获取当前url；type=0 自定义路由；type=1模块/控制器/方法
    protected function getUrlStr($type=0)
    {
        $urldata=request()->routeInfo();
        if($type){
            return ($urldata['route']);
        }else{
            return $urldata['rule'];
        }
    }

    //面包屑
    public function setCrumbs()
    {
        $urlStr = $this->getUrlStr();
        $urlStr = explode('<', $urlStr);
        $urlStr = "/" . trim($urlStr[0], "/");
        $locate = db('rules')
            ->where('rule_str', $urlStr)
            ->find();
        $location = ['frule' => '', 'location' => $locate['rule_name']];
        if ($locate['pid'] != 0) {
            //获取父级路由
            $frule = db('rules')
                ->where('id', $locate['pid'])
                ->find();
            $location['frule'] = $frule;
        }
        $this->assign('menu_navigate', $location);
    }



}
