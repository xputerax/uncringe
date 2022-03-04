<?php
declare(strict_types=1);

require(dirname(__FILE__) . '/../vendor/autoload.php');

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$container = new League\Container\Container;
$container->add(\App\Controller\HomeController::class)
    ->addArgument(\League\Plates\Engine::class)
    ->addArgument($psr17Factory->createResponse());

$container->add(\League\Plates\Engine::class)
    ->addArgument(dirname(__FILE__) . '/../src/View');

$strategy = new League\Route\Strategy\ApplicationStrategy;
$strategy->setContainer($container);

$router = new \League\Route\Router;
$router->setStrategy($strategy);

$router->map('GET', '/', [App\Controller\HomeController::class, 'index']);

$response = $router->dispatch($request = $creator->fromGlobals());

(new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
