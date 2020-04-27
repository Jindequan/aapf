<?php

namespace AF\Core;

use APF\Tool\constant\ExceptionCode;
use AF\Exception\FrameException;

class Router
{
    /**
     * 默认返回controller目录下对应的class
     * @param $uri
     * @return $class
     */
    function getControllerClass()
    {
        $uri = (new Request())->getRequestUri();
        $uri = trim($uri, '/');
        if (empty($uri)) {
            return $this->getClass('IndexController');
        }

        list($file, $class) = $this->getFile($uri);
        if (defined('CONTROLLER_PATH')) {
            $filePath = CONTROLLER_PATH . $file;
        } else {
            $filePath = APP_PATH . '/Controller/' . $file;
        }

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
        $route = include $routeFile;
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

    function getFile($uri)
    {
        $uriArray = explode('/', $uri);
        $file = '';
        $class = '';
        foreach ($uriArray as $dir) {
            $tmp = str_replace('-', '_', strtolower($dir));
            $file .= '/' . $tmp;
            $class .= '\\' . $tmp;
        }
        $class = $class . 'Controller';
        $file .= 'Controller.php';
        return [$file, $class];
    }

    function getClass($class)
    {
        return "App\Controller" . "\\" . trim($class, '\\');
    }
}