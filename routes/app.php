<?php

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('bye', new Routing\Route('/bye'));

$routes->add('hello', new Routing\Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => [new \App\Controllers\WelcomeController(), 'index'],
]));

return $routes;
