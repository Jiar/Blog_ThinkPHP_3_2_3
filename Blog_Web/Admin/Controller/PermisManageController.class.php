<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 2016/10/16
 * Time: 下午9:40
 */

namespace Admin\Controller;

class PermisManageController extends BaseController {

    /**
     * 管理员进入某账户权限管理界面
     *
     * @param $type 账户类型 1:管理员
     * @param $id   账户Id
     */
    public function permissionAction($type, $id) {
        if($type == 1) {
            $admin = D('Admin');
            $admin = $admin->find($id);
            $this->assign('type', '管理员');
            $this->assign('admin', $admin);
            $this->display('Permission/permission');
        }
    }

    /**
     * 管理员查看所有权限
     */
    public function allPermissionsAction() {

    }

    /**
     * 管理员添加权限
     */
    public function addPermissionAction() {

    }

    /**
     * 管理员修改权限
     */
    public function modifyPermissionAction() {

    }

    /**
     * 管理员删除权限
     */
    public function deletePermissionAction() {

    }

}