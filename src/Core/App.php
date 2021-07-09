<?php
namespace AF\Core;

use AF\AbstractCenter\AppAbstract;
use AF\Common\Response;
use AF\Common\Router;

class App extends AppAbstract
{
    public function run()
    {
        $this->process();

        $this->pushToNext();
    }

    public function process()
    {
        //it contain all php life flow of this request
        $controllerClass = Router::getInstance()->process();
        $result = (new $controllerClass)->handle();
        Response::successJson($result);
    }

    public function pushToNext()
    {
        Response::failJson();
    }
}