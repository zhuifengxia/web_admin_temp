<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');


/**
 * 登陆
 */
Route::group('adminauth',[
    '/'=>['admin/Adminauth/Login',['method' => 'get']],
    'dologin'=>['admin/Adminauth/doLogin',['method' => 'post']],
    'loginOut'=>['admin/Adminauth/loginOut'],
]);


/**
 * 后台管理相关
 */
Route::group('admin',[
    //首页
    'index'=>['admin/Admin/index',['method' => 'get']],
    //系统管理行业分类信息管理
    'system/industry/[:fatherid]'   => ['admin/System/industryTypes', ['method' => 'get']],
    'system/addIndustry/[:typeid]/[:datatype]' => ['admin/System/addIndustry', ['method' => 'get']],
    'system/doAddIndustry' => ['admin/System/doAddIndustry', ['method' => 'post']],
    'system/delIndustry/:typeid/:datatype' => ['admin/System/delIndustry'],

    //商铺类型/加盟类型管理
    'system/shoptypes/[:datatype]'   => ['admin/System/shopTypes', ['method' => 'get']],

    //友情链接管理
    'system/links'   => ['admin/System/links', ['method' => 'get']],
    'system/addLink/[:linkid]' => ['admin/System/addLink', ['method' => 'get']],
    'system/doAddLink' => ['admin/System/doAddLink', ['method' => 'post']],
    'system/delLink/:linkid' => ['admin/System/delLink'],

    //商铺转让管理
    'business/transfer'   => ['admin/Business/shopTransfer', ['method' => 'get']],
    'business/addTransfer/[:id]' => ['admin/Business/addTransfer'],
    'business/doAddTransfer' => ['admin/Business/doAddTransfer', ['method' => 'post']],
    'business/uploadfiles' => ['admin/Business/uploadFiles'],
    'business/delPic' => ['admin/Business/delPic'],
    'business/delTransfer/:id' => ['admin/Business/delTransfer'],

    //二手房管理
    'business/handhouse'   => ['admin/Business/handHouse', ['method' => 'get']],
    'business/addHandhouse/[:id]' => ['admin/Business/addHandhouse'],
    'business/doAddHandhouse' => ['admin/Business/doAddHandhouse', ['method' => 'post']],
    'business/delHandhouse/:id' => ['admin/Business/delHandhouse'],

    //厂房仓库管理
    'business/workware'   => ['admin/Business/workwareHouse', ['method' => 'get']],
    'business/addWorkware/[:id]' => ['admin/Business/addWorkware'],
    'business/doAddWorkware' => ['admin/Business/doAddWorkware', ['method' => 'post']],
    'business/delWorkware/:id' => ['admin/Business/delWorkware'],

    //求购求租管理
    'business/supplydemand'   => ['admin/Business/supplyDemand', ['method' => 'get']],
    'business/addSupply/[:id]' => ['admin/Business/addSupply'],
    'business/doAddSupply' => ['admin/Business/doAddSupply', ['method' => 'post']],
    'business/delSupply/:id' => ['admin/Business/delSupply'],

    //加盟信息管理
    'business/joins'   => ['admin/Business/Joins', ['method' => 'get']],
    'business/addJoin/[:id]' => ['admin/Business/addJoin'],
    'business/doAddJoin' => ['admin/Business/doAddJoin', ['method' => 'post']],
    'business/delJoin/:id' => ['admin/Business/delJoin'],

    //客服精英管理
    'users/customers'   => ['admin/Users/customers', ['method' => 'get']],
    'users/addCustomer/[:id]' => ['admin/Users/addCustomer'],
    'users/doAddCustomer' => ['admin/Users/doAddCustomer', ['method' => 'post']],
    'users/delCustomer/:id' => ['admin/Users/delCustomer'],

    //用户管理
    'users'   => ['admin/Admin/Users', ['method' => 'get']],
    'addUser/[:userid]' => ['admin/Admin/addUser'],
    'doAddUser' => ['admin/Admin/doAddUser', ['method' => 'post']],
    'delUser/:userid' => ['admin/Admin/delUser'],
]);



return [

];
