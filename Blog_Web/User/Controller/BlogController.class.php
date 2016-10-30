<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/14
 * Time: 上午11:59
 */

namespace User\Controller;

use Think\Controller;


class BlogController extends Controller {

    public function addBlog_action() {
        if(session('?userId') && session('?userToken')) {
            $this->display('Blog/addBlog');
        } else {
            redirect(U('User/user'));
        }
    }

    public function addBlogForm_action() {
        $blog = D('Blog');
        $where['user_id'] = session('userId');
        $blog = $blog->where($where)->order('blog_id desc')->select();
        $blog_id = $blog[0]['blog_id']+1;
        $data = array();
        if($_FILES['cover_img']["size"] == 0) {
            $data['cover_img'] = getWebRootPath() .'Public/Static/images/blog-cover-default.jpeg';
        } else {
            $config = array(
                'maxSize'    =>    3145728,
                'rootPath'   =>    C('DEFAULT_UPLOADS'),
                'savePath'   =>    'Blogs/',
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
                'autoSub'    =>    true,
                'subName'    =>    array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);
            $info = $upload->uploadOne($_FILES['cover_img']);
            if(!$info) {
                $this->error(structureErrorInfo($upload->getError()));
            }
            $data['cover_img'] = getWebRootPath().substr(C('DEFAULT_UPLOADS'), 2).$info['savepath'].$info['savename'];
        }
        $data['user_id'] = session('userId');
        $data['blog_id'] = $blog_id;
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['create_time'] = date('Y-m-d H:i:s');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        $blog = D('Blog');
        if(!$blog->create($data)) {
            $this->error(structureErrorInfo($blog->getError()));
        } else {
            $blog->add();
            redirect(U('User/user'));
        }
    }

    public function modifyBlog_action($userId, $blogId) {
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
            $this->display('Blog/modifyBlog');
        } else {
            redirect(U('User/user'));
        }
    }

    public function modifyBlogForm_action() {
        $where['user_id'] = I('post.user_id');
        $where['blog_id'] = I('post.blog_id');
        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['last_modify_time'] = date('Y-m-d H:i:s');
        D('Blog')->where($where)->save($data);
        redirect(U('User/user'));
    }

    public function deleteBlog_action($userId, $blogId) {
        if(session('?userId') != $userId) {
            $this->error('无法删除别人的博客');
            return;
        }
        if(session('?userId') && session('?userToken')) {
            $data['user_id'] = $userId;
            $data['blog_id'] = $blogId;
            D('Blog')->where($data)->delete();
        }
        redirect(U('User/user'));
    }

    public function detailBlog_action($user,$blogId) {
        $tempUser = D("User");
        $result = $tempUser->getByName($user);
        if(count($result) == 0) {
            $this->error('找不到用户:' .$user);
            return;
        }
        $userId = $result['id'];
        $data['user_id'] = $userId;
        $data['blog_id'] = $blogId;
        $blog = D('Blog')->where($data)->select();
        if(count($blog) == 0) {
            $this->error('找不到该博客');
            return;
        }
        $blog = $blog[0];
        if($blog['is_block'] == 1) {
            $this->error('该文章已被管理员屏蔽，无法查看详情。');
            return;
        }
        $read_count = $blog['read_count']+1;
        $where['user_id'] = $userId;
        $where['blog_id'] = $blogId;
        $data['read_count'] = $read_count;
        $save = D('Blog');
        $save->where($where)->save($data);
        $blog['user'] = $user;
        $blog['read_count'] = $read_count;
        $this->assign('blog', $blog);
        $this->assign('userId', $userId);
        $this->display('Blog/detailBlog');
    }

}