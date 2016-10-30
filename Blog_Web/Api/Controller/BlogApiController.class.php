<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/30
 * Time: 上午12:53
 */

namespace Api\Controller;

use Think\Controller;

class BlogApiController extends Controller {

    /**
     * 用户发布博文,POST
     *
     * @param user_id    用户Id
     * @param token      用户token
     * @param title      博文标题
     * @param cover_img  博文首页图片(可选) 支持格式:jpg, gif, png, jpeg 大小限制:3145728
     * @param content    博文内容
     *
     * @return {"success":0, "info":"info"}
     * success为0表示获取失败，1表示获取成功；无论是否获取成功info表示内容
     */
    public function addBlog_action() {
        header("Access-Control-Allow-Origin: *");
        $blog = D('Blog');
//        $user_id = I('post.user_id');
//        $token = I('post.token');
        $user_id = 2;
//        $where['id'] = $user_id;
//        $where['token'] = $token;
//        $users = D('User')->where($where)->select();
//        if(count($users) == 0) {
//            $backEntity['success'] = 0;
//            $backEntity['info'] = '该用户不存在或token失效';
//            $this->ajaxReturn(json_encode($backEntity), 'JSON');
//        }
        $where = null;
        $where['user_id'] = $user_id;
        $blog = $blog->where($where)->order('blog_id desc')->select();
        $blog_id = $blog[0]['blog_id']+1;

        $data = array();
        if($_FILES['cover_img']["size"] == 0) {
            $path = WEB_ROOT;
            $path = explode('/', $path);
            $rootName = '/';
            if(count($path) > 2) {
                $rootName = $rootName .$path[count($path)-2] .'/';
            }
            $data['cover_img'] = $rootName .'Public/Static/images/blog-cover-default.jpeg';
        } else {
            $config = array(
                'maxSize'    =>    3145728,
                'rootPath'   =>    './Uploads/',
                'savePath'   =>    'Blogs/',
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub'    =>    true,
                'subName'    =>    array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);
            $info = $upload->uploadOne($_FILES['cover_img']);
            if(!$info) {
                $backEntity['success'] = 0;
                $backEntity['info'] = $upload->getError();
                $this->ajaxReturn(json_encode($backEntity), 'JSON');
            }
            $data['cover_img'] = getWebRootPath().$info['savepath'].$info['savename'];
        }
        $data['title'] = I('post.title');
        $data['user_id'] = $user_id;
        $data['blog_id'] = $blog_id;
        $data['content'] = I('post.content');
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $blog = D('Blog');
        if(!$blog->create($data)) {
            $backEntity['success'] = 0;
            $backEntity['info'] = $blog->getError();
            $this->ajaxReturn(json_encode($backEntity), 'JSON');
        } else {
            $blog->add();
            $where = null;
            $where['user_id'] = $user_id;
            $where['blog_id'] = $blog_id;
            $blog = D('Blog')->where($where)->select();
            $blog = $blog[0];
            $backEntity['success'] = 1;
            $backEntity['info'] = $blog;
            $this->ajaxReturn(json_encode($backEntity), 'JSON');
        }
    }

}

