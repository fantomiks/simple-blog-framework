<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Welcome';
        $content = 'Hello';

        return $this->render('welcome', ['title' => $title, 'body' => $content]);
    }
}
