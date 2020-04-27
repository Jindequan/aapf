<?php
namespace AF\exception;

use APF\Tool\constant\ExceptionCode;
use Throwable;

class FrameException extends \Exception
{
    public function __construct($code = 0, $message = "", Throwable $previous = null)
    {
        $message = empty($message) ? ExceptionCode::from()->getValue($code) : $message;
        parent::__construct($message, $code, $previous);
    }
}