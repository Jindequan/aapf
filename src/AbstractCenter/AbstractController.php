<?php


namespace AF\AbstractCenter;


abstract class AbstractController
{
    abstract public function handle();

    abstract public function beforeHandle();

    abstract public function afterHandle();
}