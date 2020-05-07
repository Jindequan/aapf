<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ .'/../common.php';

$app = require_once __DIR__ . '/../Core/App.php';
(new \AF\Core\App())->run();
