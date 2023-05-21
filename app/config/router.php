<?php

use Phalcon\Mvc\Micro\Collection;
use app\middleware\CorsMiddleware;

$application->before(new CorsMiddleware());

$default = new Collection();
$default->setHandler('app\controllers\IndexController', true);

$default->get('/api', 'getAction');
$default->post('/api', 'postAction');
$default->put('/api', 'putAction');
$default->delete('/api', 'deleteAction');

$default->options('/{params:[a-zA-Z0-9\/]+}', function () use ($application) {
    $application->response->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->sendHeaders();
});

$application->mount($default);

$application->after(function() use($application) {
    $application->response->setContentType('application/json', 'UTF-8');
    $output_content = json_encode($application->getReturnedValue(), JSON_UNESCAPED_SLASHES);

    $application->response->setContent($output_content);
    $application->response->send();
});

$application->notFound(function () use ($application) {
    $application->response->setStatusCode(404, 'Not Found');
    $application->response->sendHeaders();

    $message = 'Action Not Found';
    $application->response->setContent($message);
    $application->response->send();
});

$application->error(function(\Exception $ex) use($application) {
    $content = [
        'status' => 'ERROR',
        'code' => $ex->getCode(),
        'description' => $ex->getMessage()
    ];

    $application->response->setContentType('application/json', 'UTF-8');
    $output_content = json_encode($content, JSON_UNESCAPED_SLASHES);
    $application->response->setContent($output_content);
    $application->response->setStatusCode(400);
    $application->response->send();
    exit;
});