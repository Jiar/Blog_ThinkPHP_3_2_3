<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/27
 * Time: 上午11:21
 */

namespace Api\Model;

use Think\Model;

class UserModel extends Model {

    protected $_validate = array(
        array('name','4,20','用户名长度:4~20',self::EXISTS_VALIDATE,'length'),
        array('email','email','未输入邮箱或格式错误'),
        array('name','6,30','密码长度:6~30',self::EXISTS_VALIDATE,'length'),
    );

    protected $_auto = array(
        array('password', 'sha1', self::MODEL_BOTH, 'function'),
//        array('name', 'email', 3, 'field'),
    );

    protected $_scope = array(
        'default' => array(),
        'USER_ALL_USERS' => array(),
        'USER_ID_1'  => array(
            'where' => array('id' => 1),
        ),
    );
}