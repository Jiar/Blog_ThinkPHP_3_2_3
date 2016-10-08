<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_CONTROLLER'    =>  'Api', // 默认控制器名称
//    'DEFAULT_ACTION'        =>  '', // 默认操作名称
    'URL_HTML_SUFFIX'       => 'html',
    'ACTION_SUFFIX' => 'Action',

    'VIEW_PATH' => './Public/View/',

    //  基于角色的数据库方式验证 RBAC
    'USER_AUTH_ON' => true,             // 是否需要认证
    'USER_AUTH_TYPE' => 2,              // 认证类型
    'USER_AUTH_KEY' => 'adminId', // 认证识别号
    'REQUIRE_AUTH_MODULE' => 'AdminApi',   // 需要认证模块
    'NOT_AUTH_MODULE' => '',            // 无需认证模块
    'USER_AUTH_GATEWAY' => '/AdminApi/Api/signin', // 认证网关
    'RBAC_ROLE_TABLE' => 'blog_admin_role', // 角色表名称
    'RBAC_USER_TABLE' => 'blog_admin_role_admin', // 用户表名称
    'RBAC_ACCESS_TABLE' => 'blog_admin_access', // 权限表名称
    'RBAC_NODE_TABLE' => 'blog_admin_node', // 节点表名称
);