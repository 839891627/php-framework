<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 11:04
 */

namespace core\lib;

class route
{

    public $ctrl;
    public $action;

    public function __construct()
    {
        // 目标：访问 xx.com/index/index 执行 indexcontroller.index
        /**
         * 1. 隐藏 index.php: apache 或者 nginx 中配置
         * 2. 获取 url 参数部分
         * 3. 返回对应的控制器和方法
         */
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') {
            $pathArr = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
            $uri = explode('/', $pathArr['0']);

            $this->ctrl = $uri['0'];
            $this->action = $uri['1'] ?? conf::get('route.action');

            // url 多余部分，当做是 get 的值: xx.com/index/index/id/1
            if (count($uri) % 2 != 0) {
                throw new \Exception('url 参数异常');
            }
            if (count($uri) == 2) {
                return true;
            }
            // 剔除 ctrl 和 action 部分
            array_shift($uri);
            array_shift($uri);

            for ($i = 0; $i <= count($uri) / 2; $i += 2) {
                $_GET[$uri[$i]] = $uri[$i + 1];
            }
        } else {
            // $this->ctrl = 'index';
            // $this->action = 'index';

            // 用配置文件获取默认路由
            $this->ctrl = conf::get('route.ctrl');
            $this->action = conf::get('route.action');
        }
    }
}