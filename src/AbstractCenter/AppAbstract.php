<?php
namespace AF\AbstractCenter;

use AF\InterfaceCenter\Flow;

abstract class AppAbstract implements Flow
{
    public function process()
    {
        return ;
    }

    public function pushToNext()
    {
        return ;
    }
}