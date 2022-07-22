<?php

namespace App\Repository;


use App\Db\Database;
use App\Model\Comment;

class CommentRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'comments';
    }

    protected function getModelClass(): string
    {
        return Comment::class;
    }

    public function countCommentsOnArticle(int $articleId): int
    {
        return $this->db
            ->table($this->getTableName())
            ->fetch(Database::PDO_FETCH_VALUE)
            ->where('article_id', $articleId)
            ->runCountQuery();
    }
}
