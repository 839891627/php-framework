<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 11:01
 */

namespace core;

use core\lib\log;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class imooc
{

    private static $classMap = []; // 避免重复引入，维护一个 已经 include 的 class map
    private $assign = [];

    /**
     * 处理(路由)请求
     * @throws \Exception
     */
    public static function run()
    {
        // 加载日志类
        log::init();

        $route = new \core\lib\route;

        $ctrlClass = $route->ctrl;
        $action = $route->action;

        $ctrlFile = APP . '/ctrl/' . $ctrlClass . 'Ctrl.php';

        if (is_file($ctrlFile)) {
            include $ctrlFile;

            $ctrlClass = '\\' . MODULE . '\\ctrl\\' . $ctrlClass . 'Ctrl';
            $ctrl = new $ctrlClass;
            $ctrl->$action();
            log::log('请求 ctrl:' . $ctrlClass . '::' . $action);
        } else {
            throw new \Exception('找不到控制器' . $ctrlClass);
        }
    }

    /**
     * 类文件自动加载
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public static function load($class)
    {
        // 自动加载类库
        // new \core\route();
        // $class = '\core\route'; 传入的类名命名空间需要转换成路径
        // IMOOC.'/core/route.php';

        if (isset(self::$classMap[$class])) {
            // 如果已经引入
            return true;
        }

        $class = str_replace('\\', '/', $class);
        $classFile = IMOOC . '/' . $class . '.php';
        if (is_file($classFile)) {
            include $classFile;
            self::$classMap[$class] = $class;
        } else {
            throw new \Exception('文件不存在：' . $classFile);
        }
    }

    /**
     * 模板变量赋值
     * @param string $name
     * @param $value
     */
    protected function assign(string $name, $value)
    {
        $this->assign[$name] = $value;
    }

    /**
     * 渲染页面
     * @param string $view
     */
    protected function display(string $view)
    {
        $viewFile = APP . '/views/' . $view . '.html';
        if (is_file($viewFile)) {

            $loader = new FilesystemLoader(APP . '/views');
            $twig = new Environment($loader, [
                'cache' => APP . '/views/cache',
            ]);
            $template = $twig->load('user.html');

            echo $template->render($this->assign);
        }
    }

    public function __call($name, $arguments)
    {
        p('控制器 ' . static::class . ' 不存在 ' . $name . ' 方法');
        exit();
    }
}