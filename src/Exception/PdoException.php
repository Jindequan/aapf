<?php
namespace AF\Exception;

use AF\Constants\ExceptionCode;
use Throwable;

class PdoException extends \Exception
{
    public function __construct($code = 30000, $message = "", Throwable $previous = null)
    {
        $message = empty($message) ? ExceptionCode::from()->getValue($code) : $message;
        parent::__construct($message, $code, $previous);
    }
}