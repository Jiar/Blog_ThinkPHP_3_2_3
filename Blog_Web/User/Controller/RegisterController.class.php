<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/27
 * Time: 下午8:25
 */

namespace User\Controller;

use Think\Controller;

class RegisterController extends Controller {

    public function registerByWeb() {
        $user = D('User');
        $data['name'] = $_POST['name'];
        $data['password'] = $_POST['password'];
        $data['email'] = $_POST['email'];
        $data['sex'] = (int)$_POST['sex'];
        $data['userUrl'] = 'http://localhost:9090/User/' .$_POST['name'] .'/';
        $data['token'] = 'token' .date('YmdHis');
        $data['createTime'] = date('Y-m-d H:i:s');
//        $data['lastModifyTime'] = date('Y-m-d H:i:s');
//        $data['lastLoginTime'] = date('Y-m-d H:i:s');

//        var_dump($user->create($data));
//        var_dump($user->save($user->create($data)));


        if (!$user->create($data)){ // 创建数据对象
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            $this->ajaxReturn($user->getError(),'json');
        }else{
            // 验证通过 写入新增数据
            $this->ajaxReturn($user->add(),'json');
        }

    }
}