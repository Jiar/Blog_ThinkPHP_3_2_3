<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午1:32
 */

namespace User\Controller;

use Think\Controller;

class UserController extends Controller {

    // 进入主界面
    public function userAction() {
        if(session('?userId') && session('?userToken')) {
            redirect('/User/Home/user/username/' .cookie('name') );
        } else {
            redirect('login');
        }
    }

    // 进入登录界面
    public function loginAction() {
        if(session('?userId') && session('?userToken')) {
            redirect('user');
        } else {
            $this->display('User/login');
        }
    }

    // 进入注册界面
    public function registerAction() {
        if(session('?userId') && session('?userToken')) {
            redirect('user');
        } else {
            $this->display('User/register');
        }
    }

    // 登录操作
    public function signinAction() {
        if(session('?userId') && session('?userToken')) {
            redirect('user');
        } else {
            $account = I('post.account');
            $password = sha1(I("post.password"));
            if(filter_var($account, FILTER_VALIDATE_EMAIL)) {
                // 邮箱登录
                $data['email'] = $account;
                $data['password'] = $password;
                $result = D('User')->where($data)->select();
                $result = $result[0];
                if(count($result) == 0) {
                    $this->error('该用户不存在');
                    return;
                }
                if($result['is_block'] == 1) {
                    $this->error('该用户已被管理员屏蔽');
                    return;
                }
                $this->saveDataBySignin($result);
            } else {
                // 用户登录
                $data['name'] = $account;
                $data['password'] = $password;
                $result = D('User')->where($data)->select();
                $result = $result[0];
                if(count($result) == 0) {
                    $this->error('该用户不存在');
                    return;
                }
                if($result['is_block'] == 1) {
                    $this->error('该用户已被管理员屏蔽');
                    return;
                }
                $this->saveDataBySignin($result);
            }
        }
    }

    // 注册操作
    public function signupAction() {
        $user = D('User');
        $name = I('post.name');
        $data['name'] = $name;
        $data['password'] = I('post.password');
        $data['repassword'] = I('post.repassword');
        $data['email'] = I('post.email');
        $data['token'] = sha1('TOKEN:' .$name .date('YmdHis'));
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['userurl'] = '/User/Home/' .$name;
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $data['last_login_time'] = date('Y-m-d H:i:s');
        if (!$user->create($data)){
            $this->error(structureErrorInfo($user->getError()));
        }else{
            $result = D('User')->select($user->add());
            $result = $result[0];
            session('userId', $result['id']);
            session('userToken', $result['token']);
            cookie('name',$result['name']);
            cookie('avatar',$result['avatar']);
            redirect('user');
        }
    }

    // 退出操作
    public function signoutAction() {
        session('[destroy]');
        session('[regenerate]');
//        cookie(null);
        cookie('name',null);
        cookie('avatar',null);
        redirect('login');
    }

    // 登录后保存session和cookie
    private function saveDataBySignin($result) {
        if(count($result) != 0) {
            $id = $result['id'];
            $data['id'] = $id;
            $data['token'] = sha1('TOKEN:' .$result['name'] .date('YmdHis'));
            $data['last_login_time'] = date('Y-m-d H:i:s');
            D('User')->save($data);
            $result = D('User')->select($id);
            $result = $result[0];
            session('userId', $result['id']);
            session('userToken', $result['token']);
            cookie('name',$result['name']);
            cookie('avatar',$result['avatar']);
            redirect('user');
        } else {
            $this->error('账户或密码错误');
        }
    }

}