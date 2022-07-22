<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Auth {

    private Session $session;

    private array $users = [
        'ivan@example.com' => 'a-111111',
        'alex@example.com' => 'b-111111',
    ];

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function isAuth(): bool
    {
        if ($this->session->has('is_auth')) {
            return true;
        }
        return false;
    }

    public function auth(string $login, string $password): bool
    {
        if (!empty($pwd = $this->users[$login] ?? null) && $pwd === $password) {
            $this->session->set('is_auth', true);
            $this->session->set('login', $login);
            return true;
        } else {
            $this->session->set('is_auth', false);
            return false;
        }
    }

    public function getLogin(): ?string
    {
        if ($this->isAuth()) {
            return $this->session->get('login');
        }
        return null;
    }

    public function logout(): void
    {
        $this->session->clear();
    }
}
