<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/15
 * Time: 下午6:17
 */

namespace Admin\Controller;

class BlogManageController extends BaseController {

    /**
     * 管理员查看所有博客
     */
    public function allBlogs_action() {
        $blogs = D('Blog');
        $blogs = $blogs->table('blog_blog blog, blog_user user')->where('blog.user_id = user.id')->field('blog.id as id, blog.blog_id as blog_id, blog.user_id as user_id, blog.title as title, blog.content as content, blog.comment as comment, blog.create_time as create_time, blog.last_modify_time as last_modify_time, blog.is_block as blog_is_block, blog.read_count as read_count, user.name as user_name, user.email as user_email, user.is_block as user_is_block')->order('blog.id asc')->select();
        $this->assign('blogs', $blogs);
        $this->display('BlogManage/allBlogs');
    }

    /**
     * 管理员查看博客详情
     *
     * @param $id 博客id（主键）
     */
    public function detailBlog_action($id) {
        $blog = D('Blog');
        $blog = $blog->find($id);
        $user = D('User');
        $data['id'] = $blog['user_id'];
        $user = $user->where($data)->select();
        $user = $user[0];
        $blog['user_name'] = $user['name'];
        $this->assign('blog', $blog);
        $this->display('BlogManage/detailBlog');
    }

    /**
     * 管理员屏蔽或屏蔽恢复博客
     *
     * @param $id 博客id（主键）
     */
    public function blockBlog_action($id) {
        $blog = D('Blog');
        $blog = $blog->find($id);
        $where['id'] = $id;
        $data['is_block'] = $blog['is_block']==0?1:0;
        $blog = D('Blog');
        $blog->where($where)->save($data);
        redirect('/Admin/BlogManage/allBlogs');
    }

}