<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/16
 * Time: 下午10:38
 */

namespace Admin\Controller;


class RoleManageController extends BaseController {

    /**
     * 管理员查看所有角色
     */
    public function allRolesAction() {
        $admins = D('Admin')->select();
        $this->assign('admins', $admins);
        $this->display('AdminManage/allAdmins');
    }

    /**
     * 管理员添加角色
     */
    public function addRoleAction() {

    }

    /**
     * 管理员修改角色
     */
    public function modifyRoleAction() {

    }

    /**
     * 管理员删除角色
     */
    public function deleteRoleAction() {

    }

    /**
     * 管理员查看角色详情
     *
     * @param $id 角色id（主键）
     */
    public function detailRoleAction($id) {

    }

}