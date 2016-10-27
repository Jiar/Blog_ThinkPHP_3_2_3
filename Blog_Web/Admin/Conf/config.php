<?php
return array(

    'DEFAULT_CONTROLLER'    =>  'Admin', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'admin', // 默认操作名称

    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => '664198',
    'DB_NAME' => 'Blog_ThinkPHP3.2.3',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'blog_',

    //  基于角色的数据库方式验证 RBAC
    'USER_AUTH_ON' => true,             // 是否需要认证
    'USER_AUTH_TYPE' => 2,              // 认证类型
    'USER_AUTH_KEY' => 'adminId',       // 认证识别号

//    'ADMIN_AUTH_KEY'    => 'admin',
//    REQUIRE_AUTH_MODULE => 'Admin',
//    'REQUIRE_AUTH_MODULE' => 'BlogManage,UserManage',   // 需要认证模块Controller
//    'NOT_AUTH_MODULE' => 'Public',                      // 无需认证模块
    'USER_AUTH_GATEWAY' => '/Admin/Admin/login',          // 认证网关

//    'USER_AUTH_MODEL' => 'blog_admin',
    'RBAC_ROLE_TABLE' => 'blog_admin_role',               // 角色表名称
    'RBAC_USER_TABLE' => 'blog_admin_role_admin',         // 用户表名称
    'RBAC_ACCESS_TABLE' => 'blog_admin_access',           // 权限表名称
    'RBAC_NODE_TABLE' => 'blog_admin_node',               // 节点表名称

);