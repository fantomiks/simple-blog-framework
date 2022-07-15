<?php

namespace App\Core;

class Application
{
    private Database $db;

    public function __construct(array $config)
    {
        if (!empty($config['database'])) {
            $this->db = new Database( $config['database'] );
        }
    }

    public function getDatabase(): Database
    {
        return $this->db;
    }
}
