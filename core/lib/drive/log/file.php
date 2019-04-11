<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 19:38
 */

namespace core\lib\drive\log;


use core\lib\conf;

class file
{
    private $path;

    public function __construct()
    {
        $this->path = conf::get('log.option')['path'];
    }

    public function log($msg, $level = 'info', $file = 'log')
    {
        /**
         * 1. 确定文件存储位置是否存在
         *      新建目录
         * 2. 写入日志
         */
        if (!is_dir($this->path)) {
            mkdir($this->path, '0777', true);
        }

        $msg = sprintf('%s [%s]: %s' . PHP_EOL, date('Y-m-d H:i:s'), $level, json_encode($msg, JSON_UNESCAPED_UNICODE));
        file_put_contents($this->path . '/' . $file . '_' . date('Ymd') . '.log', $msg, FILE_APPEND);
    }
}