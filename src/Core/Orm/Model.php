<?php


namespace AF\Core\Orm;

/**
 * 请求通道
 * 承载具体的数据库请求方法
 * 用户定义的数据库链接，sql语句，where条件等直接作用处
 * Class Model
 * @package AF\Core\Orm
 */
abstract class Model
{
    abstract public function table();

    public function suffix()
    {
        return '';
    }


}