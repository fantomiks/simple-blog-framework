<?php

namespace App\Model;

class Comment
{
    private int $id;
    private string $user_id;
    private string $article_id;
    private string $content;
    private int $created_at;
    private int $updated_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getArticleId(): string
    {
        return $this->article_id;
    }

    /**
     * @param string $article_id
     */
    public function setArticleId(string $article_id): void
    {
        $this->article_id = $article_id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    /**
     * @param int $created_at
     */
    public function setCreatedAt(int $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return int
     */
    public function getUpdatedAt(): int
    {
        return $this->updated_at;
    }

    /**
     * @param int $updated_at
     */
    public function setUpdatedAt(int $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
