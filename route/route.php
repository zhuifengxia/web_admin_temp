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
 * 后台管理相关
 */
Route::group('admin',[
    //登录相关
    'auth'=>['admin/AdminAuth/Login',['method' => 'get']],
    'login'=>['admin/AdminAuth/doLogin',['method' => 'post']],
    'loginOut'=>['admin/AdminAuth/loginOut'],

    //后台首页
    'index'=>['admin/Admin/index',['method' => 'get']],

    //管理组管理
    'group/list'   => ['admin/Group/groupList', ['method' => 'get']],
    'group/add/[:id]'   => ['admin/Group/groupAdd', ['method' => 'get|post']],
    'group/delete/:id'   => ['admin/Group/groupDel', ['method' => 'get']],
]);



return [

];
