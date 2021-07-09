<?php

namespace AF\Constants;

class MiddlewareCode extends BaseConstants
{
    const STEP_CONTINUE = 1;
    const STEP_BREAK = 2;


    public $all = [
        self::STEP_CONTINUE => 'access continue',
        self::STEP_BREAK => 'access break',
    ];
}