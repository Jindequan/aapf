<?php

namespace AF\Constants;

class ExceptionCode extends BaseConstants
{
    const FILE_NOT_EXIST = 10001;
    const CLASS_NOT_EXIST = 10002;
    const FUNCTION_NOT_EXIST = 10003;
    const PARAM_NOT_EXIST = 10004;
    const CONFIG_NOT_EXIST = 10005;
    const VARIABLE_NOT_EXIST = 10006;
    const CONSTANT_NOT_EXIST = 10007;
    const URL_NOT_EXIST = 10008;
    const INTERRUPTED_ACCESS = 11001;

    public $all = [
        self::FILE_NOT_EXIST => '文件不存在',
        self::CLASS_NOT_EXIST => '类不存在',
        self::FUNCTION_NOT_EXIST => '方法不存在',
        self::PARAM_NOT_EXIST => '参数不存在',
        self::CONFIG_NOT_EXIST => '配置不存在',
        self::VARIABLE_NOT_EXIST => '变量不存在',
        self::CONSTANT_NOT_EXIST => '常量不存在',
        self::URL_NOT_EXIST => '访问不存在',
        self::INTERRUPTED_ACCESS => '访问中断',
    ];
}