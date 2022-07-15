<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('welcome', new Routing\Route('/', [
    '_controller' => [new \App\Controllers\WelcomeController(), 'index'],
]));

$routes->add('articles', new Routing\Route('/articles', [
    '_controller' => [new \App\Controllers\ArticleController(), 'index'],
]));

return $routes;
