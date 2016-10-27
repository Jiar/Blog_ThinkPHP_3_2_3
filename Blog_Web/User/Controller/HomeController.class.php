<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/10/9
 * Time: 上午12:46
 */

namespace User\Controller;

use Think\Controller;

class HomeController extends Controller {

    public function home_action() {
        $this->display('Home/home');
    }

    public function user_action($username) {
        $user = D("User");
        $result = $user->getByName($username);
        if(count($result) == 0) {
            $this->error('找不到用户:' .$username);
        } else {
            $blogs = D('Blog');
            $userId =  $result['id'];
            $data['user_id'] = $userId;
            $blogs = $blogs->where($data)->select();
            $this->assign('blogs', $blogs);
            $this->assign('userId', $userId);
            $this->display('Home/user');
        }
    }

}