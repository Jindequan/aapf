<?php
namespace AF\Exception;

use AF\Constants\ExceptionCode;
use Throwable;

class CurlException extends \Exception
{
    public function __construct($code = 20000, $message = "", Throwable $previous = null)
    {
        $message = empty($message) ? ExceptionCode::from()->getValue($code) : $message;
        parent::__construct($message, $code, $previous);
    }
}