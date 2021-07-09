<?php


namespace AF\AbstractCenter;


abstract class AbstractMiddleware
{
    abstract function handle();

    abstract function showInformation();
}