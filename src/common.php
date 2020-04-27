<?php

use AF\Core\Request;
use AF\Log;
register_shutdown_function(function () {
    $error = error_get_last();
    if (!is_null($error)) {
        $errorType = $error['type'];
        $func = get_error_type($errorType);
        (new APF\Tool\log\Log())->$func(get_error_message($error));
        if (Request::getInstance()->isAjax() || Request::getInstance()->needJson()) {
            APF\Core\Response::failJson();
        }
        (new Page())->specialPage('5xx', ['message' => $error['message'], 'error' => $error]);
    }
});

set_exception_handler(function (\Throwable $e){
    $message = get_exception_message($e);
    (new Log())->error($message);
    if (Request::getInstance()->isAjax() || Request::getInstance()->needJson()) {
        APF\Core\Response::failJson($e->getMessage());
    }
    (new Page())->specialPage('5xx', ['message' => $message, 'error' => $e]);
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
        'message::' . $error["message"] .
        '; line::' . $error["line"] .
        '; file::' .$error["file"];
}

function get_exception_message(\Throwable $e) {
    return
        'message::' . $e->getMessage() .
        '; line::' . $e->getLine() .
        '; file::' .$e->getFile() .
        '; trace::' .$e->getTraceAsString();
}