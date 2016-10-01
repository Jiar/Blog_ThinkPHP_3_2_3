<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午1:32
 */

namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller {

    public function _initialize() {
        if(!session('?adminId') || !session('?adminToken')) {
            $this->error('登录超时,请重新登录!', U('Admin/Admin/signin'));
        }
        $access = \Org\Util\Rbac::AccessDecision();
        if(!$access) {
            $this->error('抱歉,您没有权限!');
        }
    }

}