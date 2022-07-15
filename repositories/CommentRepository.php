<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends AbstractRepository
{
    protected string $table = 'comments';
    protected string $modelClass = Comment::class;
}
