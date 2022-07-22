<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/../config/di.php');
/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../config/routes.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $request->attributes->add($request->query->all());
    $request->attributes->add($request->request->all());
    $container->set(Request::class, $request);
    $response = $container->call($request->attributes->get('_controller'), $request->attributes->all());
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred', 500);
}

$response->send();

