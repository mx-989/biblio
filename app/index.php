<?php
require __DIR__ . '/vendor/autoload.php';

use App\Router;
use App\utils\HttpException;

header('Content-Type: application/json; charset=utf-8');

set_exception_handler(function ($exception) {
    if (method_exists($exception, 'getHttpCode')) {
        http_response_code($exception->getHttpCode());
    } else {
        http_response_code($exception->getCode() ?: 500);
    }

    echo json_encode([
        'error' => $exception->getMessage()
    ]);
    exit;
});

try {
    $router = new Router();
    $router->run();
} catch (HttpException $e) {
    http_response_code($e->getHttpCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
