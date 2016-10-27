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
    public function allAdmins_action() {
        $admins = D('Admin')->select();
        $this->assign('admins', $admins);
        $this->display('AdminManage/allAdmins');
    }

    /**
     * 管理员添加其他管理员
     */
    public function addAdmin_action() {

    }

    /**
     * 管理员修改其他管理员
     */
    public function modifyAdmin_action() {

    }

    /**
     * 管理员删除其他管理员
     */
    public function deleteAdmin_action() {

    }

    /**
     * 管理员查看管理员详情
     *
     * @param $id 其他管理员id（主键）
     */
    public function detailAdmin_action($id) {
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
    public function examinePass_action($id) {
        $where['id'] = $id;
        $admin = D('Admin');
        $data['is_examine'] = 1;
        $admin->where($where)->save($data);
        redirect(U('AdminManage/allAdmins'));
    }

    /**
     * 管理员审核拒绝其他管理员
     *
     * @param $id 其他管理员id（主键）
     */
    public function examineRefuse_action($id) {
        $where['id'] = $id;
        $admin = D('Admin');
        $data['is_examine'] = 2;
        $admin->where($where)->save($data);
        redirect(U('AdminManage/allAdmins'));
    }

    /**
     * 管理员屏蔽或屏蔽恢复其他管理员
     *
     * @param $id 其他管理员id（主键）
     */
    public function blockAdmin_action($id) {
        $admin = D('Admin');
        $admin = $admin->find($id);
        $where['id'] = $id;
        $data['is_block'] = $admin['is_block']==0?1:0;
        $admin = D('Admin');
        $admin->where($where)->save($data);
        redirect(U('AdminManage/allAdmins'));
    }

}