<?php


namespace AF\Tool;


use AF\Constants\ExceptionCode;
use AF\Exception\CurlException;

class CurlHandler extends BaseTool
{
    private $container = [];

    private $permitMethod = ['get', 'post', 'put'];
    private $defaultMethod = 'get';

    private $format = ['json', 'xml'];
    private $defaultFormat = 'json';

    private $defaultTimeout = 5;
    private $defaultConnectTimeout = 3;

    private $response = [];

    public function setUrl(string $url)
    {
        $this->container['url'] = $url;
    }

    public function setHeader($headers)
    {
        $this->container['header'] = $headers;
    }

    public function getHeader()
    {
        return $this->container['header'] ?? false;
    }

    public function setNoBody()
    {
        $this->container['no_body'] = true;
    }

    public function getNoBody()
    {
        return $this->container['no_body'] ?? false;
    }

    public function setTimeout(int $time)
    {
        $this->container['timeout'] = $time;
    }

    public function getTimeout()
    {
        return $this->container['timeout'] ?? $this->defaultTimeout;
    }

    public function setConnectTimeout(int $time)
    {
        $this->container['connect_timeout'] = $time;
    }

    public function getConnectTimeout()
    {
        return $this->container['connect_timeout'] ?? $this->defaultConnectTimeout;
    }

    public function setFormat(string $format)
    {
        if (!in_array($format, $this->format)) {
            throw new CurlException(ExceptionCode::NOT_PERMITTED_FORMAT);
        }
        $this->container['format'] = $format;
    }

    public function getFormat()
    {
        return $this->container['format'] ?? $this->defaultFormat;
    }

    public function setMethod(string $method = 'get')
    {
        $method = strtolower($method);
        if (!in_array($method, $this->permitMethod)) {
            throw new CurlException(ExceptionCode::NOT_PERMITTED_METHOD);
        }
        $this->container['method'] = $method;
        return $this;
    }

    private function setDefaultMethod()
    {
        $this->container['method'] = $this->defaultMethod;
    }

    public function getMethod()
    {
        return $this->container['method'] ?? $this->defaultMethod;
    }

    public function setHeaders($headers = [])
    {
        $this->container['headers'] = $headers;
        return $this;
    }

    public function getHeaders()
    {
        return $this->container['headers'] ?? [];
    }

    public function getResult()
    {
        return $this->res;
    }

    public function start($getResult = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->container['url']);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->container['timeout']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->container['connect_timeout']);
        curl_setopt($ch, CURLOPT_POST, $this->getMethod() == 'post');
        curl_setopt($ch, CURLOPT_NOBODY, $this->getNoBody());
        curl_setopt($ch, CURLOPT_HEADER, $this->getHeader());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        $this->response = [
            'http_code' => curl_getinfo($ch,CURLINFO_HTTP_CODE),
            'result' => $res,
        ];

        if ($getResult) {
            return $this->response;
        }
        return $this;
    }

    public function end()
    {
        $this->container = [];
        $this->response = [];
        return true;
    }
}