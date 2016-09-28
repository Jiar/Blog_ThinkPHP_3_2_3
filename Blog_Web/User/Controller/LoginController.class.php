<?php
/**
 * Created by PhpStorm.
 * User: Jiar
 * Date: 16/9/26
 * Time: 下午5:17
 */

namespace User\Controller;

use Think\Controller;

class LoginController extends Controller  {

    //http://localhost:9090/user.php/User/Login/login/username/Jiar/password/123
    //http://localhost:9090/user.php?m=User&c=Login&a=login&username=Jiar&password=123
    public function login($username, $password) {
        echo 'user:' .$username ." " .'password:' .$password;
    }

    public function test() {
        echo 'test';
    }

}