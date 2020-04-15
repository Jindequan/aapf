<?php
namespace AF\Core;

use AF\AbstractCenter\AppAbstract;

class App extends AppAbstract
{
    public function run()
    {
        $this->process();

        $this->pushToNext();
    }

    public function process()
    {

    }
}