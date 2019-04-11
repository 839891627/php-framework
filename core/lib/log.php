<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 19:35
 */

namespace core\lib;


class log
{
    public static $class;

    /**
     * 1. 确定存储方式
     * 2. 写日志
     */

    public static function init()
    {
        $drive = conf::get('log.drive');
        $class = '\core\lib\drive\log\\' . $drive;
        self::$class = new $class;
    }

    public static function log($msg, $level = 'info', $target = 'log')
    {
        self::$class->log($msg, $level, $target);
    }
}