<?php
/**
 * @author: arvin.cao@shoufuyou.com
 * Date: 2019-04-10
 * Time: 13:55
 */

namespace core\lib;


class model extends \Medoo\Medoo
{
    public function __construct()
    {
        $db = conf::get('db');
        parent::__construct($db);
    }
}