<?php


namespace AF\Common;


use AF\AbstractCenter\AbstractMiddleware;
use AF\Constants\ExceptionCode;
use AF\Constants\MiddlewareCode;
use AF\Exception\FrameException;
use AF\InterfaceCenter\Flow;

class Middleware implements Flow
{
    private $requestUri = '';
    private $middlewareNamespace = '';
    private $middleware = [];
    private $middlewareIgnore = [];
    private $middlewareList = [];


    protected static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function process()
    {
        $this->setMiddlewareNamespace();
        $this->getMiddleware();
        if (empty($this->middleware)) {
            return ;
        }
        $this->parseMiddleware();
        $this->execute();
        return $this->pushToNext();
    }

    public function pushToNext()
    {
        return ;
    }

    public function setUri($requestUri)
    {
        $this->requestUri = $requestUri;
        return $this;
    }

    private function setMiddlewareNamespace()
    {
        $this->middlewareNamespace = defined('MIDDLEWARE_NAMESPACE') ?
            MIDDLEWARE_NAMESPACE :
            'App\Middleware';
    }

    private function getMiddleware()
    {
        $middlewareConfigFile = CONFIG_PATH . 'middleware.php';
        if (!file_exists($middlewareConfigFile)) {
            return ;
        }
        $config = include_once $middlewareConfigFile;

        if (!empty($config['global'])) {
            $this->middleware = array_merge($this->middleware, $config['global']);
        }
        if (!empty($config[$this->requestUri])) {
            $this->middleware = array_merge($this->middleware, $config[$this->requestUri]);
        }
        if (!empty($config['!global'])) {
            $this->middlewareIgnore = $config['!global'];
        }
    }

    private function parseMiddleware()
    {
        $ignore = [];
        foreach ($this->middlewareIgnore as $v) {
            if (empty($v) || !is_string($v) || $v[0] == '!') continue;
            $ignore[$v] = $v;
        }
        $needExecuteArr = [];
        foreach ($this->middleware as $v) {
            if (empty($v) || !is_string($v)) continue;
            if ($v[0] == '!') {
                $v = substr($v, 1);
                $ignore[$v] = $v;
            } else {
                $needExecuteArr[$v] = $v;
            }
        }
        $this->middlewareList = array_diff($needExecuteArr, $ignore);
    }

    private function execute()
    {
        foreach ($this->middlewareList as $className) {
            $this->executeSingle($className);
        }
    }

    private function executeSingle($className)
    {
        $class = $this->getClass($className);
        if (empty($class) || !class_exists($class) || !($class instanceof AbstractMiddleware)) {
            throw new FrameException(ExceptionCode::CLASS_NOT_EXIST, 'middleware class not exist:' . $class);
        }
        $obj = new $class;
        if ($obj->handle() != MiddlewareCode::STEP_CONTINUE) {
            throw new FrameException(ExceptionCode::INTERRUPTED_ACCESS, $obj->showInformation());
        }
    }

    private function getClass($className)
    {
        return $this->middlewareNamespace . '\\' . $className;
    }
}