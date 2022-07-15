<?php

namespace App\Repositories;

use App\Core\Database;

abstract class AbstractRepository
{
    protected Database $database;
    protected string $table;
    protected string $modelClass;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function fetchAll(int $limit = 10, int $offset = 0): array
    {
        $query = $this->database
            ->table($this->table)
            ->fetch(Database::PDO_FETCH_MULTI)
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'ASC');

        $models = [];
        foreach ($query->runSelectQuery() as $row) {
            $models[] = new $this->modelClass($row);
        }

        return $models;
    }

    public function totalCount(): int
    {
        return $this->database
            ->table($this->table)
            ->fetch(Database::PDO_FETCH_VALUE)
            ->runCountQuery();
    }

    public function findById(int $id): mixed
    {
        $query = $this->database
            ->table($this->table)
            ->where('id', $id)
            ->fetch(Database::PDO_FETCH_SINGLE);

        return new $this->modelClass($query->runSelectQuery());
    }
}
