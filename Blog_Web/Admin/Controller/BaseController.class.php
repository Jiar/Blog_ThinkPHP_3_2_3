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

    function _initialize() {
        if(!session('?adminId') || !session('?adminToken')) {
            $this->error('登录超时,请重新登录', U('Admin/Admin/login'));
        }
        $access = \Org\Util\Rbac::AccessDecision();
        if(!$access) {
            $this->error('抱歉,您没有该权限');
        }
    }

//    function _initialize() {
//        // 用户权限检查
//        if (C ( 'USER_AUTH_ON' ) && !in_array(MODULE_NAME,explode(',',C('NOT_AUTH_MODULE')))) {
//            import ( '@.Org.RBAC' );
//            if (! \Org\Util\Rbac::AccessDecision ()) {
//                //检查认证识别号
//                if (! $_SESSION [C ( 'USER_AUTH_KEY' )]) {
//                    //跳转到认证网关
//                    redirect ( PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
//                }
//                // 没有权限 抛出错误
//                if (C ( 'RBAC_ERROR_PAGE' )) {
//                    // 定义权限错误页面
//                    redirect ( C ( 'RBAC_ERROR_PAGE' ) );
//                } else {
//                    if (C ( 'GUEST_AUTH_ON' )) {
//                        $this->assign ( 'jumpUrl', PHP_FILE . C ( 'USER_AUTH_GATEWAY' ) );
//                    }
//                    // 提示错误信息
//                    $this->error ( L ( '_VALID_ACCESS_' ) );
//                }
//            }
//        }
//    }

    public function indexAction() {
        echo 'index';
    }

}