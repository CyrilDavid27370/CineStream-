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

    return $request->fetchall(PDO::FETCH_CLASS, Genre::class);
  }

  public function add(Genre $genre)
  {
    $sql = "INSERT INTO genre (name) VALUES (:name)";
    $request = $this->pdo->prepare($sql);
    $request->execute(['name' => $genre->getName()]);
  }

  public function findById(int $id): ?Genre
  {
    $sql = "SELECT * FROM genre WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
    $request->setFetchMode(PDO::FETCH_CLASS, Genre::class);

    return $request->fetch() ?: null;
  }

  public function findByName($name)
  {
    $sql = "SELECT * FROM genre WHERE name = :name";
    $request = $this->pdo->prepare($sql);
    $request->execute(['name' => $name]);
    $request->setFetchMode(PDO::FETCH_CLASS, Genre::class);

    return $request->fetch() ?: null;
  }

  
  public function update(int $id, Genre $genre)
  {
    $sql = "UPDATE genre SET name = :name WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute([
      'name' => $genre->getName(),
      'id' => $id
    ]);
  }

  public function delete(int $id)
  {
    $sql = "DELETE FROM genre WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
  }
}
