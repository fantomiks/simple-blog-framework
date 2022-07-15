<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    public function index($request)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views/');
        $twig = new \Twig\Environment($loader,
//            [
//            'cache' => __DIR__ . '/../cache/',
//        ]
        );

        $title = 'Welcome';
        $content = 'Hello';


        $template = $twig->load('/welcome.php');

        return new Response($template->render(['title' => $title, 'body' => $content]));
    }
}
