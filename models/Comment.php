<?php

namespace App\Models;

class Comment
{
    use Timestampable;

    private int $id;
    private string $content;
    private int $user_id;
}
