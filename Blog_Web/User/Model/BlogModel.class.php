<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午1:43
 */

namespace User\Model;

use Think\Model;

class BlogModel extends Model {
    protected $patchValidate = ture;
    protected $_validate = array(
        array('title','1,50','标题长度范围:1~50',self::EXISTS_VALIDATE,'length'),
        array('content','require','必须输入内容！'),
    );

}

