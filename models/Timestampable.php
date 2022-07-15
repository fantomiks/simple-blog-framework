<?php

namespace App\Models;

trait Timestampable
{
    private int $created_at;
    private int $updated_at;
    private ?int $deleted_at;

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

    /**
     * @return ?int
     */
    public function getDeletedAt(): ?int
    {
        return $this->deleted_at;
    }

    /**
     * @param ?int $deleted_at
     */
    public function setDeletedAt(?int $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }
}
