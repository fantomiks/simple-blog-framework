<?php

namespace App\Repository;

use App\Db\Database;
use PDO;

abstract class Repository
{
    protected Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function findById(int $id): ?array
    {
        $data = $this->db
            ->table($this->getTableName())
            ->orderBy('created_at', 'ASC')
            ->fetch(Database::PDO_FETCH_SINGLE)
            ->where('id', $id)
            ->runSelectQuery();

        if (!$data) {
            return null;
        }

        return $data;
    }

    public function findAll(int $limit = 10, int $offset = 0): ?array
    {
        $rows = $this->db
            ->table($this->getTableName())
            ->fetch(Database::PDO_FETCH_MULTI)
            ->orderBy('created_at', 'ASC')
            ->limit($limit)
            ->offset($offset)
            ->runSelectQuery();

        if (!$rows) {
            return [];
        }

        return $rows;
    }

    public function count(): int
    {
        return $this->db
            ->table($this->getTableName())
            ->fetch(Database::PDO_FETCH_VALUE)
            ->runCountQuery();
    }

    abstract protected function getTableName(): string;
    abstract protected function getModelClass(): string;
}
