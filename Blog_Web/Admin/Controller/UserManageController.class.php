<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/15
 * Time: 下午6:17
 */

namespace Admin\Controller;

class UserManageController extends BaseController {

    /**
     * 管理员查看所有用户
     */
    public function allUsers_action() {
        $users = D('User')->select();
        $this->assign('users', $users);
        $this->display('UserManage/allUsers');
    }

    /**
     * 管理员查看用户详情
     *
     * @param $id 用户id（主键）
     */
    public function detailUser_action($id) {
        $user = D('User');
        $user = $user->find($id);
        $this->assign('user', $user);
        $this->display('UserManage/detailUser');
    }

    /**
     * 管理员屏蔽或屏蔽恢复用户
     *
     * @param $id 用户id（主键）
     */
    public function blockUser_action($id) {
        $user = D('User');
        $user = $user->find($id);
        $where['id'] = $id;
        $data['is_block'] = $user['is_block']==0?1:0;
        $user = D('User');
        $user->where($where)->save($data);
        redirect('/Admin/UserManage/allUsers');
    }

}