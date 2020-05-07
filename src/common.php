<?php

use AF\Common\Request;
use AF\Common\Response;
use AF\Log\Log;
register_shutdown_function(function () {
    $error = error_get_last();
    if (!is_null($error)) {
        $errorType = $error['type'];
        $func = get_error_type($errorType);
        (new Log())->$func(get_error_message($error));
        Response::failJson();
    }
});

set_exception_handler(function (\Throwable $e){
    $message = get_exception_message($e);
    (new Log())->error($message);
    Response::failJson($e->getMessage(), $e->getCode());
});

function get_error_type($errorType) {
    switch ($errorType) {
        case E_ERROR :
            $func = 'error';
            break;
        case E_WARNING :
            $func = 'warning';
            break;
        case E_NOTICE :
            $func = 'notice';
            break;
        default :
            $func = 'info';
    }

    return $func;
}

function get_error_message($error) {
    return
        'trace_id::' . Request::getInstance()->getTraceId() .
        '; message::' . $error["message"] .
        '; line::' . $error["line"] .
        '; file::' .$error["file"];
}

function get_exception_message(\Throwable $e) {
    return
        'trace_id::' . Request::getInstance()->getTraceId() .
        '; message::' . $e->getMessage() .
        '; line::' . $e->getLine() .
        '; file::' .$e->getFile() .
        '; trace::' .$e->getTraceAsString();
}