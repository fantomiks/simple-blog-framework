<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Service\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(Request $request, Auth $authService): Response
    {
        if ($authService->isAuth()) {
            return new RedirectResponse('/');
        }

        if ($request->isMethod('post')) {

            $login = $request->request->get('email');
            $password = $request->request->get('password');

            if ($authService->auth($login,$password)) {
                return new RedirectResponse('/');
            }
            $error = 'Login or Password are invalid, try again.';
        }

        return $this->render('login', ['error' => $error ?? null]);
    }
}
