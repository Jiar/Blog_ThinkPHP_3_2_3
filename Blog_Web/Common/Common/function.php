<?php
/**
 * Created by: Jiar
 * Github: https://www.github.com/Jiar/
 * Date: 16/9/29
 * Time: 下午7:09
 */

define('WEB_ROOT', substr(dirname(__FILE__), 0, -strlen('Blog_Web/Common/Common')));

function getWebRootPath() {
    $path = WEB_ROOT;
    $path = explode('/', $path);
    $rootName = '/';
    if(count($path) > 2) {
        $rootName = $rootName .$path[count($path)-2] .'/';
    }
    return $rootName;
}

/**
 * 判断一个PHP数组是关联数组还是数字数组
 *
 * @param $arr  传入变量
 * @return bool 是否为关联数组
 */
function is_assoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * 构建错误信息并返回
 *
 * @param $error  错误信息
 * @return string 构建后的错误信息
 */
function structureErrorInfo($error) {
    if(!is_assoc($error)) {
        return $error;
    }
    $result = "Error:</br>";
    foreach($error as $key=>$value) {
        $result = $result .$key ."&nbsp:&nbsp" .$value ."</br>";
    }
    return $result;
}