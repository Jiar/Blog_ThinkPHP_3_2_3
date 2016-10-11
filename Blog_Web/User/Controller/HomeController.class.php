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
        $data['user_id'] = session('userId');
        $blog = $blog->where($data)->order('blog_id desc')->select();
        $blog_id = $blog[0]['blog_id']+1;
        $blog = D('Blog');
        $data['title'] = I('post.title');
        $data['user_id'] = session('userId');
        $data['blog_id'] = $blog_id;
        $data['content'] = I('post.content');
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        if(!$blog->create($data)) {
            $this->error(structureErrorInfo($blog->getError()));
        } else {
            $blog->add();
            redirect('/User/User/user');
        }
    }

    public function modifyBlogAction($userId, $blogId) {
        if(session('?userId') != $userId) {
            $this->error('无法修改别人的博客');
            return;
        }
        if(session('?userId') && session('?userToken')) {
            $blog = D('Blog');
            $data['user_id'] = $userId;
            $data['blog_id'] = $blogId;
            $blog = $blog->where($data)->select();
            if(count($blog) == 0) {
                $this->error('找不到该博客');
                return;
            }
            $blog = $blog[0];
            $this->assign('blog', $blog);
            $this->display('Home/modifyBlog');
        } else {
            redirect('/User/User/user');
        }
    }

    public function modifyBlogFormAction() {
        $blog = D('Blog');
        $where['user_id'] = I('post.user_id');
        $where['blog_id'] = I('post.blog_id');
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $blog->where($where)->save($data);
        redirect('/User/User/user');
    }

    public function deleteBlogAction($userId, $blogId) {
        if(session('?userId') != $userId) {
            $this->error('无法删除别人的博客');
            return;
        }
        if(session('?userId') && session('?userToken')) {
            $blog = D('Blog');
            $data['user_id'] = $userId;
            $data['blog_id'] = $blogId;
            $blog->where($data)->delete();
        }
        redirect('/User/User/user');
    }

    public function detailBlogAction($user,$blogId) {
        $tempUser = D("User");
        $result = $tempUser->getByName($user);
        if(count($result) == 0) {
            $this->error('找不到用户:' .$user);
            return;
        }
        $userId = $result['id'];
        $blog = D('Blog');
        $data['user_id'] = $userId;
        $data['blog_id'] = $blogId;
        $blog = $blog->where($data)->select();
        if(count($blog) == 0) {
            $this->error('找不到该博客');
            return;
        }
        $blog = $blog[0];
        $blog['username'] = $user;
        $this->assign('blog', $blog);
        $this->assign('userId', $userId);
        $this->display('Home/detailBlog');
    }

}