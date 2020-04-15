<?php

namespace AF\InterfaceCenter;


interface Flow
{
    /**
     * 执行
     * @return mixed
     */
    public function process();

    /**
     * 交给下一位处理者
     * @return mixed
     */
    public function pushToNext();
}