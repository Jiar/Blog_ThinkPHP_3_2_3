<?php
namespace User\Controller;
use Think\Controller;
use Think\Model;
use User\Model\UserModel;

class UserController extends Controller {
    public function index(){
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
//        $this->show('User');
        $this->theme('blue')->display();
    }

    public function model() {
//        $model = new Model("User");
//        var_dump($model->select());

//        $user = new UserModel();
//        var_dump($user->select());

//        $user = D('User');

//        var_dump($user->where("id = 1")->select());

//        $condition["id"  = 1;
//        var_dump($user->where($condition)->select());

//        $condition = new \StdClass();
//        $condition->id = '1';
//        $condition->name = 'Jiar';
//        $condition->_logic = 'AND';
//        var_dump($user->where($condition)->select());

//        $map['id'] = array("EQ", 1);
//        $map['_string'] = 'name = "Jiar" AND email = "jiar.world@qq.com"';
//        $map['_query'] = 'name=Jiar&email=jiar.world@qq.com';
//        $where['id'] = 2;
//        $map['_complex'] = $where;
//        var_dump($user->where($map)->select());

//        var_dump($user->count());
//        var_dump($user->getByName('Jiar'));

//        var_dump($user->getFieldByName('Jiar', 'id'));
//        var_dump($user->query('SELECT * FROM blog_user'));
//        var_dump($user->execute('UPDATE blog_user SET name = "Jiar" WHERE id = "1"'));

//        var_dump($user->scope('USER_ALL_USERS')->select());

        $user = D('User');
        $this->ajaxReturn($user->scope(USER_ALL_USERS)->select(),'json');

    }
}