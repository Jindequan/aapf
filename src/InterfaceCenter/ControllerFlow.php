<?php


namespace AF\InterfaceCenter;


interface ControllerFlow
{
    public function beforeHandle();

    public function handle();

    public function afterHandle();
}