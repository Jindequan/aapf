<?php

namespace AF\Tool;

use AF\Constants\ExceptionCode;
use AF\Exception\FrameException;

class Config
{
    protected static $config = [
        'test' => [
            'pdd' => 'a',
            'pdf' => 'b'
        ]
    ];

    public static function get($key = '', $useFile = true, $reload = false)
    {
        if (empty($key)) {
            return self::$config;
        }
        $indexes = explode('.', $key);
        return self::getByIndexes($indexes, $useFile, $reload);
    }

    public static function set($key, $value)  {
        if (empty($key)) {
            throw new FrameException(ExceptionCode::PARAM_NOT_EXIST);
        }
        $indexes = explode('.', $key);
        return self::setByIndexes($indexes, $value, count($indexes));
    }

    private static function setByIndexes($indexes, $value, $index= 0, $tmp = [])
    {
        //todo 不要覆盖原始可能存在的键. (存在可操作性太大，数据会发生类型的随意变更)
        $tmp  = count($indexes) == $index ? $value : $tmp;
        $index -= 1;
        if ($index <= 0) {
            self::$config[$indexes[$index]] = $tmp;

            return true;
        }

        $newTmp = [
            $indexes[$index] => $tmp
        ];
        return  self::setByIndexes($indexes, $value, $index, $newTmp);
    }

    private static function getByIndexes($indexes, $useFile, $reload, $index = 0, $tmp = [])
    {
        if (count($indexes) < $index + 1) {
            return $tmp;
        }
        if ($index === 0) {
            $fileName = $indexes[$index];
            self::getByFileName($fileName, $useFile, $reload);
            $tmp = self::$config[$indexes[$index]] ?? null;
        } else {
            $tmp = isset($indexes[$index]) && isset($tmp[$indexes[$index]]) ? $tmp[$indexes[$index]] : null;
        }

        if (is_null($tmp)) {
            return null;
        }

        return self::getByIndexes($indexes, $index + 1, $tmp);
    }

    private static function getByFileName($fileName, $useFile, $reload)
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