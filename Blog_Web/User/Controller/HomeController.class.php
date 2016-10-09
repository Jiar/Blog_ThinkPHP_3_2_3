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

    public function userAction($username) {
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
            trace($blogs);
            $this->display('Home/user');
        }
    }

    public function addBlogAction() {
        if(session('?userId') && session('?userToken')) {
            $this->display('Home/addBlog');
        } else {
            redirect('/User/User/user');
        }
    }

    public function addBlogFormAction() {
        $blog = D('Blog');
        $data['title'] = I('post.title');
        $data['user_id'] = session('userId');
        $data['content'] = I('post.content');
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        if (!$blog->create($data)){
            $this->error($blog->getError());
        }else{
            $blog->add();
            redirect('/User/User/user');
        }
    }

    public function modifyBlogAction($blogId) {
        if(session('?userId') && session('?userToken')) {
            $blog = D('Blog');
            $blog = $blog->getById($blogId);
            $this->assign('blog', $blog);
            $this->display('Home/modifyBlog');
        } else {
            redirect('/User/User/user');
        }
    }

    public function modifyBlogFormAction() {
        $blog = D('Blog');
        $data['id'] = I('post.id');
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $blog->save($data);
        redirect('/User/User/user');
    }

    public function deleteBlogAction($blogId) {
        if(session('?userId') && session('?userToken')) {
            $blog = D('Blog');
            $blog->delete($blogId);
        }
        redirect('/User/User/user');
    }
}