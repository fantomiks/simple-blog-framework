<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('welcome', new Routing\Route('/', [
    '_controller' => \App\Controllers\WelcomeController::class,
]));

$routes->add('list_articles', new Routing\Route('/articles', [
    'page' => 1,
    '_controller' => \App\Controllers\Article\ListController::class,
]));

$routes->add('show_article', new Routing\Route('/articles/{id}', [
    'id' => 1,
    '_controller' => \App\Controllers\Article\GetController::class,
]));

$routes->add('login', new Routing\Route('/login', [
    '_controller' => \App\Controllers\Auth\LoginController::class,
]));

$routes->add('logout', new Routing\Route('/logout', [
    '_controller' => \App\Controllers\Auth\LogoutController::class,
]));

return $routes;
