<?php

namespace App\Repository;


use App\Model\User;

class UserRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'users';
    }

    protected function getModelClass(): string
    {
        return User::class;
    }
}
