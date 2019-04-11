<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 14:37
 */

namespace core\lib;

class conf
{
    const TARGET_FILE = 1;
    const TARGET_ITEM = 2;
    public static $conf = [];

    /**
     * 可以通过 "文件名.参数名" 获取指定的值（目前只支持一维）
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public static function get($name)
    {
        $parseConf = explode('.', $name);
        $file = $parseConf['0'];
        /**
         * 1. 判断配置文件是否存在
         * 2. 判断配置是否存在
         * 3. 缓存配置
         */

        // 判断是获取文件还是某项具体配置
        if (isset($parseConf['1']) && $name = $parseConf['1']) {
            $target = self::TARGET_ITEM;
        } else {
            $target = self::TARGET_FILE;
        }

        // 判断是否缓存过
        if (isset(self::$conf[$file])) {
            return $target == self::TARGET_FILE ? self::$conf[$file] : self::$conf[$file][$name];;
        }

        $realFile = IMOOC . '/core/config/' . $file . '.php';
        if (is_file($realFile)) {
            $conf = include $realFile;

            if ($target == self::TARGET_ITEM) {
                // 如果是获取某一项参数
                if (isset($conf[$name])) {
                    self::$conf[$file] = $conf;

                    return $conf[$name];
                } else {
                    throw new \Exception('找不到配置项' . $name);
                }
            } else {
                // 否则获取整个配置文件
                return $conf;
            }
        } else {
            throw new \Exception('找不到配置文件' . $realFile);
        }
    }
}