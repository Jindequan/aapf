<?php


namespace AF\Core\Orm;

use AF\Constants\ExceptionCode;
use AF\Exception\FrameException;
use AF\Exception\PdoException;

/**
 * 直接的具体的sql请求类。发出sql，返回结果。
 * Class Pdo
 * @package AF\Core\Orm
 */
class Pdo
{
    private static $instance = null;
    private $pdo = null;
    private $pk = 'id';
    private $table = '';
    private $limit = 1000;
    private $offset = 0;
    private $where = [];
    private $whereValue = [];
    private $whereRaw = [];
    private $whereRawValue = [];
    private $sql = '';
    private $selectColumns = '*';

    public function __construct($host, $port, $user, $password, $database, $option = [])
    {
        $dsn = 'mysql:dbname=' . $database . ';host=' . $host . ';port=' . $port;
        $this->pdo = new \PDO($dsn, $user, $password, $option);
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
    }

    public function select(string $columns = '*')
    {
        $this->selectColumns = $columns;
    }

    public function find(int $offset, int $limit)
    {
        $this->sql = 'select ' . $this->selectColumns . ' from ';
    }

    public function findOne()
    {
        $this->limit = 1;
    }

    public function insert(array $data)
    {
        $this->sql = 'insert into ? ? values (?)';
    }

    public function update(array $data, array $lock = [])
    {
        $this->sql = 'update ? set ?';
    }

    public function where(...$where)
    {
        $num = count($where);
        switch ($num) {
            case 1:
                $this->whereRaw[] = $where;
                break;
            case 2:
                if (is_array($where[1])) {
                    $value = '(' . implode(',', $where[1]) . ')';
                    $opt = 'in';
                } else {
                    $value = $where[1];
                    $opt = '=';
                }
                $this->whereRaw[] = $where[0] . $opt . '?';
                $this->whereRawValue[] = $value;
                break;
            case 3:
                if (is_array($where[2])) {
                    $value = '(' . implode(',', $where[2]) . ')';
                } else {
                    $value = $where[2];
                }
                $this->whereRaw[] = implode(' ', [$where[0], $where[1], '?']);
                $this->whereRawValue[] = $value;
                break;
            default:
                throw new PdoException();
        }
        return $this;
    }

    public function wheres(array $wheres)
    {
        foreach ($wheres as $item) {
            $this->where(...$item);
        }
    }

    public function whereRaw(string $whereRaw, string $whereRawValue = '')
    {
        $this->whereRaw[] = $whereRaw;
        if (!empty($whereRawValue)) {
            $this->whereRawValue[] = $whereRawValue;
        }
    }

    public function execute()
    {
        if (is_null($this->pdo)) {
            throw new PdoException(ExceptionCode::NOT_SET_CONNECTION);
        }
        try {

        } catch (\PDOException $e) {

        }
    }
}