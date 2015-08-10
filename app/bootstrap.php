<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/Application.php';
require_once __DIR__ . '/../lib/BaseController.php';
$app = SE\Application::getInstance();
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'dev');
}
if (ENVIRONMENT == 'dev') {
    $app['debug'] = true;
}

require_once 'configs/services.php';
require_once 'configs/routes.php';

if (ENVIRONMENT == 'cli') {
    $app->boot();
} else {
    $app->run();
}

return $app;