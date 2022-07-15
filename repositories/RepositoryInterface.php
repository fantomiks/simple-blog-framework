<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function fetchAll(int $limit, int $offset = 0);
    public function findById(int $id);
}
