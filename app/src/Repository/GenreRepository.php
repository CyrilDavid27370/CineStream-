<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Genre;
use PDO;

class GenreRepository extends Repository
{
  public function findAll()
  {
    $sql = "SELECT * FROM genre";
    $request = $this->pdo->prepare($sql);
    $request->execute();

    return $request->fetchall(PDO::FETCH_CLASS, genre::class);
  }
}