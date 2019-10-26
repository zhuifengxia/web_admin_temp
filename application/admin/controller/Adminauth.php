<?php
/**
 * Description: 后台登陆相关.
 * Author: momo
 * Date: 2019-06-08
 * Copyright: momo
 */
namespace app\admin\controller;
use think\Controller;

class Adminauth extends Controller
{
    /**
     * 后台账号登录页面
     */
    public function Login()
    {
        session('adminuser',null);
        // 获取包含域名的完整URL地址
        $this->assign('domain',$this->request->url(true));
        return $this->fetch('login');
    }

    /**
     * 执行登录操作
     */
    public function doLogin()
    {
        //查询数据写入session
        $adminuser=db('users')
            ->where('user_name',$_POST['username'])
            ->where('user_pwd',md5($_POST['password']))
            ->find();
        if($adminuser)
        {
            session('adminuser',$adminuser);
            echo json_encode(['code'=>0,'msg'=>"登陆成功"]);
            exit();
        }else{
            echo json_encode(['code'=>1,'msg'=>"账号或密码错误"]);
            exit();
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        session('adminuser',null);
        $this->success('退出成功！', "/adminauth");
    }
}
