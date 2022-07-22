<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Service\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __invoke(Auth $authService): Response
    {
        $authService->logout();
        return new RedirectResponse('/login');
    }
}
