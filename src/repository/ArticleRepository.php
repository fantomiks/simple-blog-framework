<?php

namespace App\Repository;


use App\Model\Article;

class ArticleRepository extends Repository
{
    protected function getTableName(): string
    {
        return 'articles';
    }

    protected function getModelClass(): string
    {
        return Article::class;
    }
}
