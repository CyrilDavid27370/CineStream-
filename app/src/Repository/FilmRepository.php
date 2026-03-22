<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;

class FilmRepository extends Repository
{

    public function findAll(int $userId)
    {
        $sql = "SELECT * FROM film WHERE user_id = :user_id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['user_id' => $userId]);
        return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }

    public function findByGenre(int $genreId, int $userId)
    {
        $sql = "SELECT * FROM film WHERE genre_id = :genre_id AND user_id = :user_id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['genre_id' => $genreId, 'user_id' => $userId]);
        return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }

    public function findByWatched(bool $isWatched, int $userId)
    {
        $sql = "SELECT * FROM film WHERE isWatched = :isWatched AND user_id = :user_id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['isWatched' => (int)$isWatched, 'user_id' => $userId]);
        return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }

    public function findByNoGenre(int $userId)
    {
        $sql = "SELECT * FROM film WHERE genre_id IS NULL AND user_id = :user_id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['user_id' => $userId]);
        return $request->fetchAll(PDO::FETCH_CLASS, Film::class);
    }

    public function findById(int $id)
    {
        $sql = "SELECT film.*, genre.name AS genre_name
                FROM film
                LEFT JOIN genre ON film.genre_id = genre.id
                WHERE film.id = :id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        return $request->fetch();
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM film WHERE id = :id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
    }

    public function update(Film $film)
    {
        $sql = "UPDATE film SET genre_id = :genre_id, description = :description, isWatched = :isWatched, rating = :rating WHERE id = :id";
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'genre_id'    => $film->getGenre_id(),
            'description' => $film->getDescription(),
            'isWatched'   => (int)$film->getIsWatched(),
            'rating'      => $film->getRating(),
            'id'          => $film->getId()
        ]);
    }

    public function add(Film $film, int $userId)
    {
        $sql = "INSERT INTO film (user_id, tmdb_id, title, poster_path, release_date, runtime, overview, isWatched)
                VALUES (:user_id, :tmdb_id, :title, :poster_path, :release_date, :runtime, :overview, :isWatched)";
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'user_id'      => $userId,
            'tmdb_id'      => $film->getTmdb_id(),
            'title'        => $film->getTitle(),
            'poster_path'  => $film->getPoster_path(),
            'release_date' => !empty($film->getRelease_date()) ? substr($film->getRelease_date(), 0, 4) : null,
            'runtime'      => $film->getRuntime(),
            'overview'     => $film->getOverview(),
            'isWatched'    => (int)$film->getIsWatched(),
        ]);
    }

    public function findByTmdbId(int $tmdbId, int $userId): ?Film
    {
        $sql = "SELECT * FROM film WHERE tmdb_id = :tmdb_id AND user_id = :user_id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['tmdb_id' => $tmdbId, 'user_id' => $userId]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        return $request->fetch() ?: null;
    }

    public function countByUser(int $userId): int
{
    $sql = "SELECT COUNT(*) FROM film WHERE user_id = :user_id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['user_id' => $userId]);
    return (int)$request->fetchColumn();
}

public function countWatchedByUser(int $userId): int
{
    $sql = "SELECT COUNT(*) FROM film WHERE user_id = :user_id AND isWatched = 1";
    $request = $this->pdo->prepare($sql);
    $request->execute(['user_id' => $userId]);
    return (int)$request->fetchColumn();
}

public function countToWatchByUser(int $userId): int
{
    $sql = "SELECT COUNT(*) FROM film WHERE user_id = :user_id AND isWatched = 0";
    $request = $this->pdo->prepare($sql);
    $request->execute(['user_id' => $userId]);
    return (int)$request->fetchColumn();
}

public function deleteByUser(int $userId): void
{
    $sql = "DELETE FROM film WHERE user_id = :user_id";
    $request = $this->pdo->prepare($sql);
    $request->execute(['user_id' => $userId]);
}
}