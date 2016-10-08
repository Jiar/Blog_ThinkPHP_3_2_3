<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/10/8
 * Time: 上午11:25
 */

namespace AdminApi\Controller;

use Think\Controller;
use AdminApi\Util\Entity\Entity;

class ApiController extends Controller {

    /**
     * 管理员注册接口 POST
     * 如果注册成功,会在session中存入:adminId、adminToken,会在cookie中存入name、avatar
     *
     * @api
     * @author Jiar <jiar.world@gmail.com>
     *
     * @param String $name     管理员名称
     * @param String $password 管理员密码
     * @param String email     管理员邮箱
     *
     * @return JSON : {
    　　　　"haveError":true,
    　　　　"info":"注册成功"
    　　}
     *
     */
    public function signupAction() {
        $admin = D('Admin');
        $name = I('post.name');
        $data['name'] = $name;
        $data['password'] = I('post.password');
        $data['email'] = I('post.email');
        $data['token'] = sha1('TOKEN:' .$name .date('YmdHis'));
        $data['createTime'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $data['last_login_time'] = date('Y-m-d H:i:s');
        if (!$admin->create($data)){
            $this->ajaxReturn(new Entity());
            return;
        }
        $result = $admin->add();
        if(!is_numeric($result)) {
            $this->ajaxReturn(new Entity());
            return;
        }
        $result = D('Admin')->select($result);
        if(count($result) != 1) {
            $this->ajaxReturn(new Entity());
            return;
        }
        $result = $result[0];
        session('adminId', $result['id']);
        session('adminToken', $result['token']);
        cookie('name',$result['name']);
        cookie('avatar',$result['avatar']);
        $result = new Entity();
        $result->haveError = false;
        $result->info = '注册成功';
        $this->ajaxReturn($result);
    }

    /**
     * 管理员登录接口 POST
     * 如果已经有账户登录(在session中检测到已经存在adminId、adminToken),则无法使用次接口,必须先退出登录。
     * 如果登录成功,会在session中存入:adminId、adminToken,会在cookie中存入name、avatar
     *
     * @api
     * @author Jiar <jiar.world@gmail.com>
     *
     * @param String $account  管理员邮箱或名字
     * @param String $password 管理员密码
     *
     * @return JSON : {
    　　　　"haveError":true,
    　　　　"info":"登录成功"
    　　}
     *
     */
    public function signinAction() {
        if(session('?adminId') && session('?adminToken')) {
            return;
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

    /**
     * 登录后保存session和cookie
     */
    private function saveDataBySignin($result) {
        if(count($result) != 1) {
            $result = new Entity();
            $result->info = '账户或密码错误';
            $this->ajaxReturn($result);
            return;
        }
        $id = $result['id'];
        $data['id'] = $id;
        $data['token'] = sha1('TOKEN:' .$result['name'] .date('YmdHis'));
        D('Admin')->save($data);
        $result = D('Admin')->select($id);
        $result = $result[0];
        session('adminId', $result['id']);
        session('adminToken', $result['token']);
        cookie('name',$result['name']);
        cookie('avatar',$result['avatar']);
        $result = new Entity();
        $result->haveError = false;
        $result->info = '登录成功';
        $this->ajaxReturn($result);
    }
}