<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Article;
use App\Models\User;

class ArticleRepository extends AbstractRepository
{
    protected string $table = 'articles';
    protected string $modelClass = Article::class;

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
            ->join('LEFT', 'users', 'users.id = articles.user_id')
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'ASC');

        $select = [
            'articles.*',
            'users.id AS user_id',
            'users.name AS user_name',
            'users.email AS user_email',
            'users.created_at AS user_created_at',
            'users.updated_at AS user_updated_at',
            'users.deleted_at AS user_deleted_at',
        ];

        $models = [];
        foreach ($query->runSelectQuery(implode(',', $select)) as $row) {
            $usersData = [];
            foreach ($row as $key => $val) {
                if (str_contains($key, 'user_')) {
                    unset($row[$key]);
                    $key = substr($key, 5);
                    $usersData[$key] = $val;
                }
            }
            $model = new $this->modelClass($row);
            $model->setUser(new User($usersData));
            $models[] = $model;
        }

        return $models;
    }
}
