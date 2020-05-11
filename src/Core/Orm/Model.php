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

    abstract public static function table();

    private static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Pdo();
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