<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/15
 * Time: 下午6:18
 */

namespace Admin\Controller;

class AdminManageController extends BaseController {

    /**
     * 管理员查看所有管理员
     */
    public function allAdminsAction() {
        $admins = D('Admin')->select();
        $this->assign('admins', $admins);
        $this->display('AdminManage/allAdmins');
    }

    /**
     * 管理员添加其他管理员
     */
    public function addAdminAction() {

    }

    /**
     * 管理员修改其他管理员
     */
    public function modifyAdminAction() {

    }

    /**
     * 管理员删除其他管理员
     */
    public function deleteAdminAction() {

    }

    /**
     * 管理员查看管理员详情
     *
     * @param $id 其他管理员id（主键）
     */
    public function detailAdminAction($id) {
        $admin = D('Admin');
        $admin = $admin->find($id);
        $this->assign('admin', $admin);
        $this->display('AdminManage/detailAdmin');
    }

    /**
     * 管理员审核通过其他管理员
     *
     * @param $id 其他管理员id（主键）
     */
    public function examinePassAction($id) {
        $where['id'] = $id;
        $admin = D('Admin');
        $data['is_examine'] = 1;
        $admin->where($where)->save($data);
        redirect('/Admin/AdminManage/allAdmins');
    }

    /**
     * 管理员审核拒绝其他管理员
     *
     * @param $id 其他管理员id（主键）
     */
    public function examineRefuseAction($id) {
        $where['id'] = $id;
        $admin = D('Admin');
        $data['is_examine'] = 2;
        $admin->where($where)->save($data);
        redirect('/Admin/AdminManage/allAdmins');
    }

    /**
     * 管理员屏蔽或屏蔽恢复其他管理员
     *
     * @param $id 其他管理员id（主键）
     */
    public function blockAdminAction($id) {
        $admin = D('Admin');
        $admin = $admin->find($id);
        $where['id'] = $id;
        $data['is_block'] = $admin['is_block']==0?1:0;
        $admin = D('Admin');
        $admin->where($where)->save($data);
        redirect('/Admin/AdminManage/allAdmins');
    }

}