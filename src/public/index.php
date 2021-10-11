<?php

define('BASEPATH', dirname(__DIR__));
define('VIEWPATH', BASEPATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);

require_once BASEPATH . DIRECTORY_SEPARATOR.'../vendor/autoload.php';

use App\app\Application;
use App\controllers\ApiController;

$app = new Application();

$app->router->get('/', 'checkout/checkout');
$app->router->get('/try-checkout', 'checkout/try-checkout');
$app->router->get('/api/health', function() {
    header('Content-Type: application/json');
    return json_encode(['ok']);
});

$app->router->post('/api/invoice', [ApiController::class, 'invoice']);

$app->run();