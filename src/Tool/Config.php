<?php

namespace AF\Tool;

use AF\Constants\ExceptionCode;
use AF\Exception\FrameException;

class Config
{
    protected static $config = [];

    public static function get($key = '')
    {
        if (empty($key)) {
            return self::$config;
        }
        $indexes = explode('.', $key);
        return self::getByIndexes($indexes);
    }

    public static function set($key, $value)  {
        if (empty($key)) {
            throw new FrameException(ExceptionCode::PARAM_NOT_EXIST);
        }
        $type = gettype($value);
        $indexes = explode('.', $key);

    }

    private static function setByIndexes($indexes, $index =  0, $tmp = [])
    {
//        if (!isset(self::$config[])) {
//            self::$config[$v] = [];
//        }
    }

    private static function getByIndexes($indexes, $index = 0, $tmp = [])
    {
        if (count($indexes) == $index) {
            return $tmp;
        }
        if ($index === 0) {
            self::getByFileName($indexes[$index]);
            $tmp = isset(self::$config[$indexes[$index]]) ?: null;
            if (is_null($tmp)) {
                return null;
            }
        }
        $index += 1;
        $tmp = isset($tmp[$indexes[$index]]) ?: null;
        if (is_null($tmp)) {
            return null;
        }

        return self::getByIndexes($indexes, $index, $tmp);
    }

    private static function getByFileName($fileName)
    {
        if (isset(self::$config[$fileName])) {
            return ;
        }
        if (defined('CONFIG_PATH')) {
            $path = CONFIG_PATH;
        } else {
            $path = ROOT_PATH . '/../config';
        }

        $file = $path . '/' . $fileName . '.php';
        if (!file_exists($file)) {
            throw new FrameException(ExceptionCode::CONFIG_NOT_EXIST);
        }
        self::$config[$fileName] = require_once $file;
    }
}