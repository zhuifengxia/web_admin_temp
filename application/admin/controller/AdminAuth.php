<?php
/**
 * Description: 后台登陆相关.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\admin\controller;
use MoCommon\Support\Helper;
use think\Controller;

class AdminAuth extends Controller
{
    /**
     * 后台账号登录页面
     */
    public function Login()
    {
        session('admin_user',null);
        return $this->fetch('login');
    }

    /**
     * 执行登录操作
     */
    public function doLogin()
    {
        //查询数据写入session
        $adminuser = db('admin')
            ->where('user_name', $_POST['username'])
            ->where('user_pwd', Helper::make_password($_POST['password'], 'admin'))
            ->find();
        if ($adminuser) {
            session('admin_user', $adminuser);
            echo json_encode(['code' => 0, 'msg' => "登陆成功"]);
            exit();
        } else {
            echo json_encode(['code' => 1, 'msg' => "账号或密码错误"]);
            exit();
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        session('admin_user',null);
        $this->success('退出成功！', "/admin/auth");
    }
}
