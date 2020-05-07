<?php


namespace AF\Core\Orm;

/**
 * 直接的具体的sql请求类。发出sql，返回结果。
 * Class Pdo
 * @package AF\Core\Orm
 */
class Pdo extends \PDO
{
    private $instance = null;
    private $pk = 'id';
    private $table = '';
    private $limit = 1000;
    private $offset = 0;
    private $where = [];
    private $whereValue = [];
    private $whereRaw = '';
    private $whereRawValue = '';

    private function __construct()
    {
    }

    public function setConnection($host, $port, $user, $password, $database, $option = [])
    {
        $dsn = 'mysql:dbname=' . $database . ';host=' . $host . ';port=' . $port;
        $this->instance = new \PDO($dsn, $user, $password, $option);
    }

    public function table(string $table)
    {
        $this->table = $table;
    }

    public function find()
    {

    }

    public function findOne()
    {

    }

    public function insert()
    {

    }

    public function update()
    {

    }
}