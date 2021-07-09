<?php

namespace AF\Common;

class Request
{
    protected static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

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

    /**
     * TraceId is a header attribute value also an unique identify.
     * when a series requests happen we should confirm which step is wrong, or we need to know what happened in that
     * so we should sign the request.
     * traceId contains three parts.
     * 1. traceId. created by the first request sender.
     * 2. trace steps. added by receiver. step is 1.
     * 3. time string. it is just an identify used with traceId. if your traceId is time string, ignore this part.
     * @return string
     */
    public function getTraceId()
    {
        $traceId = $_SERVER['HTTP_X_AF_TRACE'] ?? '';
        if (empty($traceId)) return '';
        $traceIdArr = explode('-', $traceId);

    }
}