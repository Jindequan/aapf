<?php

namespace AF\Constants;

class MiddlewareCode extends BaseConstants
{
    const STEP_CONTINUE = 1;
    const STEP_BREAK = 2;


    public $all = [
        self::FILE_NOT_EXIST => '文件不存在',
        self::CLASS_NOT_EXIST => '类不存在',
    ];
}