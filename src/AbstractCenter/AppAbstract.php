<?php
namespace AF\AbstractCenter;

use AF\InterfaceCenter\Flow;

class AppAbstract implements Flow
{
    protected $originData = [];
    protected $tmp = [];

    public function tell(array $params)
    {
        $this->originData = $params;
    }

    public function process()
    {
        // TODO: Implement process() method.
    }

    public function pushToNext()
    {
        // TODO: Implement pushToNext() method.
    }
}