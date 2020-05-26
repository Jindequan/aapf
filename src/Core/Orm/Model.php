<?php


namespace AF\Core\Orm;

use AF\Core\Orm\Pdo;

/**
 * 请求通道
 * 承载具体的数据库请求方法
 * 用户定义的数据库链接，sql语句，where条件等直接作用处
 * Class Model
 * @package AF\Core\Orm
 */
abstract class Model
{
    public static $instance;

    public static function readDB()
    {

    }

    public static function writeDB()
    {

    }

    public static function getInstance($host, $port, $user, $password, $database, $option = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new Pdo($host, $port, $user, $password, $database, $option);
        }
        return self::$instance;
    }

    public static function suffix()
    {
        return '';
    }

    public static function insert()
    {

    }

    public static function where()
    {
        return self::$instance;
    }

    public static function whereRaw()
    {

    }

}