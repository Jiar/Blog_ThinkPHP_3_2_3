<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/30
 * Time: 上午12:55
 */

namespace Api\Controller;

use Think\Controller;

class UserApiController extends Controller {

    /**
     * 获取用户信息，需要通过POST请求形式获取
     *
     * @param account  邮箱或用户名
     * @param password 登录密码
     *
     * @return {"success":0, "info":"info"}
     * success为0表示获取失败，1表示获取成功；无论是否获取成功info表示内容
     */
    public function fetchEntity_action() {
        header("Access-Control-Allow-Origin: *");
        $account = I('post.account');
        $password = sha1(I("post.password"));
        if(filter_var($account, FILTER_VALIDATE_EMAIL)) {
            // 邮箱登录
            $data['email'] = $account;
            $data['password'] = $password;
            $user = D('User')->where($data)->select();
            $user = $user[0];
            if(count($user) == 0) {
                $backEntity['success'] = 0;
                $backEntity['info'] = '该用户不存在';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
            if($user['is_block'] == 1) {
                $backEntity['success'] = 0;
                $backEntity['info'] = '该用户已被管理员屏蔽';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
            if(count($user) != 0) {
                $id = $user['id'];
                $where['id'] = $id;
                $data['token'] = sha1('TOKEN:' .$user['name'] .date('YmdHis'));
                $data['last_login_time'] = date('Y-m-d H:i:s');
                D('User')->where($where)->save($data);
                $user = D('User')->select($id);
                $user = $user[0];
                $user['password'] = '';
                $backEntity['success'] = 1;
                $backEntity['info'] = $user;
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            } else {
                $backEntity['success'] = 0;
                $backEntity['info'] = '账户或密码错误';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
        } else {
            // 用户登录
            $data['name'] = $account;
            $data['password'] = $password;
            $user = D('User')->where($data)->select();
            $user = $user[0];
            if(count($user) == 0) {
                $backEntity['success'] = 0;
                $backEntity['info'] = '该用户不存在';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
            if($user['is_block'] == 1) {
                $backEntity['success'] = 0;
                $backEntity['info'] = '该用户已被管理员屏蔽';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
            if(count($user) != 0) {
                $id = $user['id'];
                $where['id'] = $id;
                $data['token'] = sha1('TOKEN:' .$user['name'] .date('YmdHis'));
                $data['last_login_time'] = date('Y-m-d H:i:s');
                D('User')->where($where)->save($data);
                $user = D('User')->select($id);
                $user = $user[0];
                $user['password'] = '';
                $backEntity['success'] = 1;
                $backEntity['info'] = $user;
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            } else {
                $backEntity['success'] = 0;
                $backEntity['info'] = '账户或密码错误';
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
        }
    }

}