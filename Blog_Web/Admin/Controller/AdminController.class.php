<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午1:32
 */

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller {

    // 进入主界面
    public function adminAction() {
        if(session('?adminId') && session('?adminToken')) {
            $this->display('admin');
        } else {
            redirect('login');
        }
    }

    // 进入登录、注册界面
    public function loginAction() {
        if(session('?adminId') && session('?adminToken')) {
            redirect('admin');
        } else {
            $this->display('login');
        }
    }

    // 注册操作
    public function signupAction() {
        $admin = D('Admin');
        $name = I('post.name');
        $data['name'] = $name;
        $data['password'] = I('post.password');
        $data['repassword'] = I('post.repassword');
        $data['email'] = I('post.email');
        $data['token'] = sha1('TOKEN:' .$name .date('YmdHis'));
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $data['last_login_time'] = date('Y-m-d H:i:s');
        if (!$admin->create($data)){
            $this->error($admin->getError());
        }else{
            $result = D('Admin')->select($admin->add());
            $result = $result[0];
            session('adminId', $result['id']);
            session('adminToken', $result['token']);
            cookie('name',$result['name']);
            cookie('avatar',$result['avatar']);
            redirect('admin');
        }
    }

    // 登录操作
    public function signinAction() {
        if(session('?adminId') && session('?adminToken')) {
            redirect('admin');
        } else {
            $account = I('post.account');
            $password = sha1(I("post.password"));
            if(filter_var($account, FILTER_VALIDATE_EMAIL)) {
                // 邮箱登录
                $data['email'] = $account;
                $data['password'] = $password;
                $result = D('Admin')->where($data)->select();
                $result = $result[0];
                $this->saveDataBySignin($result);
            } else {
                // 用户登录
                $data['name'] = $account;
                $data['password'] = $password;
                $result = D('Admin')->where($data)->select();
                $result = $result[0];
                $this->saveDataBySignin($result);
            }
        }
    }

    // 退出操作
    public function signoutAction() {
        session('[destroy]');
        session('[regenerate]');
        cookie(null);
        redirect('login');
    }

    // 登录后保存session和cookie
    private function saveDataBySignin($result) {
        if(count($result) != 0) {
            $id = $result['id'];
            $data['id'] = $id;
            $data['token'] = sha1('TOKEN:' .$result['name'] .date('YmdHis'));
            $data['last_login_time'] = date('Y-m-d H:i:s');
            D('Admin')->save($data);
            $result = D('Admin')->select($id);
            $result = $result[0];
            session('adminId', $result['id']);
            session('adminToken', $result['token']);
            cookie('name',$result['name']);
            cookie('avatar',$result['avatar']);
            redirect('admin');
        } else {
            $this->error('账户或密码错误');
        }
    }

}