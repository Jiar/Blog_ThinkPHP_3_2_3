<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午1:43
 */

namespace User\Model;

use Think\Model;

class UserModel extends Model {
    protected $patchValidate = ture;
    protected $_validate = array(
        array('name','4,20','用户名长度范围:4~20',self::EXISTS_VALIDATE,'length'),
        array('name','checkName','该用户名已被使用',self::MODEL_BOTH,'callback'),
        array('email','email','未输入邮箱或格式错误'),
        array('email','checkEmail','该邮箱已被使用',self::MODEL_BOTH,'callback'),
        array('password','6,30','密码长度:6~30',self::EXISTS_VALIDATE,'length'),
        array('password','repassword','两次密码输入不一致',self::EXISTS_VALIDATE,'confirm'),
    );
    protected $autoCheckFields = true;
    protected $_auto = array(
        array('password', 'sha1', self::MODEL_BOTH, 'function'),
    );

    protected function checkName($name) {
        if($this->getAdminByName($name)) {
            return false;
        }
        return true;
    }

    protected function checkEmail($email) {
        if($this->getAdminByEmail($email)) {
            return false;
        }
        return true;
    }

    private function getAdminByName($name) {
        $user = D("User");
        $result = $user->getByName($name);
        if(count($result) == 0) {
            return null;
        } else {
            $result['password'] = null;
            trace($result);
            return $result;
        }
    }

    private function getAdminByEmail($email) {
        $user = D("User");
        $result = $user->getByEmail($email);
        if(count($result) == 0) {
            return null;
        } else {
            $result['password'] = null;
            trace($result);
            return $result;
        }
    }

}

