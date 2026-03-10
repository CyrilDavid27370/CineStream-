<?php

namespace Cine\App\Repository;

use PDO;

class Repository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=mysql;dbname=cine', 'user', 'pwd');
    }
}