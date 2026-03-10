<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;

class FilmRepository extends Repository
{
  public function findAll()
  {
    $sql = "SELECT * FROM film";
    $request = $this->pdo->prepare($sql);
    $request->execute();

    return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
  }
}