<?php

namespace app\ctrl;

use core\imooc;
use core\lib\conf;
use core\lib\model;

class indexCtrl extends imooc
{
    public function index()
    {
        $model = new model();
        $users = $model->select('users', ['name', 'id', 'email', 'created_at']);

        $title = '用户列表';
        $this->assign('title', $title);
        $this->assign('users', $users);
        $this->display('user');
    }

    public function test()
    {
        echo conf::get('route.ctrl');
        echo conf::get('route.action');
        p(conf::$conf);
    }
}