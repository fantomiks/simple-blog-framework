<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views/');
        $this->twig = new Environment($loader,
//            [
//            'cache' => __DIR__ . '/../cache/',
//        ]
        );
    }

    public function render(string $view, array $params): Response
    {
        $template = $this->twig->load("/$view.php");
        return new Response($template->render($params));
    }
}
