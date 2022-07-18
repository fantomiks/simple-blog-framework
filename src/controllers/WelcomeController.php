<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('welcome', [
            'title' => 'Welcome',
            'body' => 'Blog welcome page',
        ]);
    }
}
