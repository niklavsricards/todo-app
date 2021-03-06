<?php

use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

session_start();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'ToDoController@index');
    $r->addRoute('GET', '/todos', 'ToDoController@index');
    $r->addRoute('POST', '/todos/create', 'ToDoController@create');
    $r->addRoute('POST', '/todos/{id}', 'ToDoController@delete');
    $r->addRoute('GET', '/users', 'UsersController@index');
    $r->addRoute('GET', '/login', 'AuthController@loginView');
    $r->addRoute('GET', '/register', 'AuthController@registerView');
    $r->addRoute('POST', '/login', 'AuthController@login');
    $r->addRoute('POST', '/register', 'AuthController@register');
    $r->addRoute('GET', '/logout', 'AuthController@logout');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$loader = new FilesystemLoader('app/Views');
$templateEngine = new Environment($loader, []);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);
        $controller = 'App\Controllers\\' . $controller;

        $controller = new $controller();
        $response = $controller->$method($vars);

        if ($response instanceof View) {
            echo $templateEngine->render(
                $response->getTemplate(),
                $response->getArgs()
            );
        }

        break;
}