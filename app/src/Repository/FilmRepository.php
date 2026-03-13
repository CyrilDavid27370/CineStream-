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

public function findByGenre(int $genreId) 
{
    $sql = "SELECT * FROM film WHERE genre_id = :genre_id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['genre_id' => $genreId]);
    return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
}

public function findByWatched(bool $isWatched)
{
    $sql = "SELECT * FROM film WHERE isWatched = :isWatched";
    $request = $this->pdo->prepare($sql);
    $request->execute(['isWatched' => (int)$isWatched]);
    return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
}

public function findByNoGenre() 
{
    $sql = "SELECT * FROM film WHERE genre_id IS NULL";
    $request = $this->pdo->prepare($sql);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
}

public function findById(int $id) {
    $sql = "SELECT film.*, genre.name AS genre_name
    FROM film
    LEFT JOIN genre
    ON film.genre_id = genre.id
    WHERE film.id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
    $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
    
    return $request->fetch();
}

public function delete($id) {
    $sql = "DELETE FROM film WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['id' => $id]);
}

public function update(Film $film)
{
    $sql = "UPDATE film SET genre_id = :genre_id, description = :description, isWatched = :isWatched WHERE id = :id";
    $request = $this->pdo->prepare($sql);
    $request->execute([
        'genre_id' => $film->getGenre_id(),
        'description' => $film->getDescription(),
        'isWatched' => (int)$film->getIsWatched(),
        'id' => $film->getId()
    ]);
}

public function add(Film $film) {
    $sql = "INSERT INTO film (tmdb_id, title, poster_path, release_date, runtime, overview, isWatched)
            VALUES (:tmdb_id, :title, :poster_path, :release_date, :runtime, :overview, :isWatched)";
    $request = $this->pdo->prepare($sql);
    $request->execute([
        'tmdb_id' => $film->getTmdb_id(),
        'title' => $film->getTitle(),
        'poster_path' => $film->getPoster_path(),
        'release_date' => !empty($film->getRelease_date()) ? substr($film->getRelease_date(), 0, 4) : null,
        'runtime' => $film->getRuntime(),
        'overview' => $film->getOverview(),
        'isWatched' => (int)$film->getIsWatched(),
    ]);       
}

public function findByTmdbId(int $tmdbId): ?Film
{
    $sql = "SELECT * FROM film WHERE tmdb_id = :tmdb_id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['tmdb_id' => $tmdbId]);
    $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
    return $request->fetch() ?: null;
}
}