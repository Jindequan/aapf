<?php

namespace AF\Core;

class Response
{
    public static function successJson($data = [], $msg = 'success', $code = 200)
    {
        ob_clean();
        echo json_encode([
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ], JSON_UNESCAPED_UNICODE);
        die();
    }

    public static function failJson($msg = 'fail', $code = 10001, $data = [])
    {
        ob_clean();
        echo json_encode([
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ], JSON_UNESCAPED_UNICODE);
        die();
    }

    public static function redirect($url, $headers= [])
    {
        header('Location:' .$url);
    }
}