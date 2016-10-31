<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/30
 * Time: 下午11:31
 */

namespace Api\Controller;

use Think\Controller;


class HomeApiController extends Controller {

    /**
     * 获取用户的一些信息(用于进入用户主页,目前只有用户Id和用户的所有博文列表信息)
     *
     * @param $username 用户名
     *
     * @return {"success":0, "info":"info"}
     * success为0表示获取失败，1表示获取成功；无论是否获取成功info表示内容
     */
    public function user_action($username) {
        header("Access-Control-Allow-Origin: *");
        $user = D("User");
        $result = $user->getByName($username);
        if(count($result) == 0) {
            $backEntity['success'] = 0;
            $backEntity['info'] = '找不到用户:' .$username;
            $this->ajaxReturn(json_encode($backEntity), 'JSON');
        } else {
            $blogs = D('Blog');
            $userId =  $result['id'];
            $data['user_id'] = $userId;
            $blogs = $blogs->where($data)->select();
            $info['userId'] = $userId;
            $info['blogs'] = $blogs;
            $backEntity['success'] = 0;
            $backEntity['info'] = $info;
            $this->ajaxReturn(json_encode($backEntity), 'JSON');
        }
    }
}