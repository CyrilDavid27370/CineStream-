<?php

namespace Biblio\App\Repository;

use PDO;

class Repository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=mysql; dbname=librairy', 'user', 'pass');
    }
}