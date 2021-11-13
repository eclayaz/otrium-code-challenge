<?php

use App\Acme\Foo;
use App\Acme\HomeController;

$container = require __DIR__ . '/../app/bootstrap/autoload.php';

$foo = $container->get(Foo::class);
//$foo->getName();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
  $r->addRoute('GET', '/users', HomeController::class);
  // {id} must be a number (\d+)
  $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
  // The /{title} suffix is optional
  $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    // ... 404 Not Found
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    break;
  case FastRoute\Dispatcher::FOUND:
//    $handler = $routeInfo[1];
//    $vars = $routeInfo[2];

    $controller = $routeInfo[1];
    $parameters = $httpMethod == 'POST'? [$_POST] : $routeInfo[2];
//
    $container->call($controller, $parameters);
    // ... call $handler with $vars
    break;
}