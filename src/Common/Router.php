<?php

namespace AF\Common;

use AF\Constants\ExceptionCode;
use AF\Exception\FrameException;
use AF\InterfaceCenter\Flow;

class Router implements Flow
{
    private $controllerPath = '';
    private $controllerNamespace = '';
    private $requestUri = '';
    private $defaultController = '';

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
        $this->setControllerPath();
        $this->setControllerNamespace();
        $this->setDefaultController();
        $this->setRequestUri();

        $controller = $this->getControllerClass();
        $this->pushToNext();
        return $controller;
    }

    public function pushToNext()
    {
        return Middleware::getInstance()->setUri($this->requestUri)->process();
    }

    private function setControllerPath()
    {
        $this->controllerPath = defined('CONTROLLER_PATH') ?
            CONTROLLER_PATH :
            APP_PATH . '/Controller/';
    }

    private function setControllerNamespace()
    {
        $this->controllerNamespace = defined('CONTROLLER_NAMESPACE') ?
            CONTROLLER_NAMESPACE :
            "App\Controller";
    }

    private function setRequestUri()
    {
        $uri = Request::getInstance()->getRequestUri();
        $this->requestUri = trim($uri, '/');
    }

    private function setDefaultController()
    {
        $this->defaultController = defined('DEFAULT_CONTROLLER') ?
            DEFAULT_CONTROLLER :
            'IndexController';
    }

    private function getControllerClass()
    {
        if (empty($uri)) {
            return $this->getClass();
        }

        list($file, $class) = $this->getByUri($uri);
        $filePath = $this->controllerPath . $file;

        if (file_exists($filePath)) {
            return $this->getClass($class);
        }
        return $this->getByRoute($uri);
    }

    function getByRoute($uri)
    {
        $routeFile = CONFIG_PATH . '/route.php';
        if (!file_exists($routeFile)) {
            return $this->jumpNotFound();
        }
        $route = require_once $routeFile;
        if (!isset($route[$uri])) {
            return $this->jumpNotFound();
        }
        $class = $this->getClass($route[$uri]);
        if (!class_exists($class)) {
            return $this->jumpNotFound();
        }
        return $class;
    }

    function jumpNotFound()
    {
        $class = $this->getClass('NotFoundController');
        if (class_exists($class)) {
            return $class;
        }
        throw new FrameException(ExceptionCode::URL_NOT_EXIST);
    }

    function getByUri($uri)
    {
        $uriArray = explode('/', $uri);
        $file = '';
        $class = '';
        foreach ($uriArray as $dir) {
            $tmpArr = explode('-', $dir);
            $tmpArr = array_map(function ($value) {
                return ucfirst($value);
            }, $tmpArr);
            $tmp = implode('', $tmpArr);
            $file .= '/' . $tmp;
            $class .= '\\' . $tmp;
        }
        $class = $class . 'Controller';
        $file .= 'Controller.php';
        return [$file, $class];
    }

    function getClass($class = '')
    {
        if (empty($class)) {
            $class = $this->defaultController;
        }
        return $this->controllerNamespace . "\\" . trim($class, '\\');
    }
}