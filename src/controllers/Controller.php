<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Controller
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function render(string $view, array $parameters = []): Response
    {
        $template = $this->environment->load("/$view.php");

        return new Response($template->render($parameters));
    }
}
