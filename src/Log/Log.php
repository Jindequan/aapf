<?php

namespace AF\Log;
use Psr\Log\AbstractLogger;

class Log extends AbstractLogger
{
    public function log($level, $message, array $context = array())
    {
        file_put_contents(
            LOG_PATH . '/af/' . $level . '/' . date('Y-m-d') . '.log',
            $message,
            FILE_APPEND
        );
    }
}