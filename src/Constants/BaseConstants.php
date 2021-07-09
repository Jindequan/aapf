<?php


namespace AF\Constants;


class BaseConstants
{
    private static $arrayName = '';

    public static function from($arrayName = 'all')
    {
        self::$arrayName = $arrayName;
        return new static();
    }

    public function getValue($k, $default = '')
    {
        $array_name = self::$arrayName;
        return $this->$array_name[$k] ?? $default;
    }

    public function getKeyByValue($v, $onlyKey = true)
    {
        $array_name = self::$arrayName;
        $arr = $this->$array_name;
        $array = array_filter($arr, function ($value) use ($v){
            return $value == $v;
        });

        return $onlyKey ? array_keys($array) : $array;
    }
}