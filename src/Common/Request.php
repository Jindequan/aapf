<?php

namespace AF\Core;

class Request
{
    public function getParams()
    {
        return array_merge(
            $this->getGetParams(),
            $this->getPostParams()
        );
    }

    public function getGetParams()
    {
        return $_GET;
    }

    public function getPostParams()
    {
        return $_POST;
    }

    public function getServerParam()
    {
        return $_SERVER;
    }

    public function getRequestUri($direct = true)
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }

    public function isAjax()
    {
        return (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        );
    }

    public function needJson()
    {
        return $_SERVER['HTTP_ACCEPT_X_JSON'] ?? false;
    }
}