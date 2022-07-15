<?php

namespace App\Models;

class User
{
    use Timestampable;

    private int $id;
    private string $name;
    private string $email;

    public function __construct(array $data)
    {
        foreach ($data as $attribute => $value) {
            if (in_array($attribute, ['created_at', 'updated_at', 'deleted_at'])) {
                $value = $value ? strtotime($value) : null;
            }
            if (property_exists(self::class, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
