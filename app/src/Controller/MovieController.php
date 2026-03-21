<?php

namespace Cine\App\Controller;

use Cine\App\Entity\Film;
use Cine\App\Entity\Genre;
use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;
use Cine\App\Service\Tmdb\Tmdb;

class MovieController
{
    private $genreRepository;
    private $filmRepository;
    private $tmdb;
    private $userId;

    public function __construct()
    {
    $this->genreRepository = new GenreRepository;
    $this->filmRepository = new FilmRepository;
    $this->tmdb = new Tmdb;
    $this->userId = (int)$_SESSION['user_id'];
    }
    
    public function index()
    {
    $genres = $this->genreRepository->findAll();

    if (isset($_GET['genre'])) {
        if ($_GET['genre'] === 'nc') {
            $films = $this->filmRepository->findByNoGenre($this->userId);
        } else {
            $films = $this->filmRepository->findByGenre((int)$_GET['genre'], $this->userId);
        }
    } elseif (isset($_GET['filter']) && $_GET['filter'] === 'watched') {
        $films = $this->filmRepository->findByWatched(true, $this->userId);
    } elseif (isset($_GET['filter']) && $_GET['filter'] === 'towatch') {
        $films = $this->filmRepository->findByWatched(false, $this->userId);
    } else {
        $films = $this->filmRepository->findAll($this->userId);
    }

    require __DIR__ . '/../view/films/index.phtml';
}

public function show()
{
    $id = (int)$_GET['id'];
    $film = $this->filmRepository->findById($id);

    if (!$film) {
        header('Location: ?route=index');
        exit;
    }

    $this->checkFilmOwnership($film);
    require __DIR__ . '/../view/films/show.phtml';
}

public function update()
{
    $id = (int)$_GET['id'];
    $film = $this->filmRepository->findById($id);
    $genres = $this->genreRepository->findAll();

    if (!$film) {
        header('Location: ?route=index');
        exit;
    }

    $this->checkFilmOwnership($film);

    if (isset($_POST['genre_id'])) {
        $film->setGenre_id(!empty($_POST['genre_id']) ? (int)$_POST['genre_id'] : null);
        $film->setDescription($_POST['description'] ?? null);
        $film->setIsWatched(isset($_POST['isWatched']) ? (bool)$_POST['isWatched'] : false);
        $film->setRating(isset($_POST['rating']) ? (int)$_POST['rating'] : null);

        $this->filmRepository->update($film);

        $_SESSION['flash'] = '✅ Film modifié avec succès !';
        header('Location: ?route=show&id=' . $id);
        exit;
    }

    require __DIR__ . '/../view/films/update.phtml';
}

public function delete()
{
    $id = (int)$_GET['id'];
    $film = $this->filmRepository->findById($id);

    if (!$film) {
        header('Location: ?route=index');
        exit;
    }

    $this->checkFilmOwnership($film);

    $this->filmRepository->delete($id);
    header('Location: ?route=index');
    exit;
}

public function search()
{
    $films = [];

    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $results = $this->tmdb->getFilmByTmdbSearch($_GET['query']);
        $films = $results['results'];
    }

    require __DIR__ . '/../view/films/search.phtml';
}

public function showTmdb()
{
    $film = $this->tmdb->getFilmByTmdbId((int)$_GET['id']);
    $trailerKey = $this->tmdb->getTrailerKeyByTmdbId((int)$_GET['id']);
    require __DIR__ . '/../view/films/showTmdb.phtml';
}

public function genres()
{
    $genres = $this->genreRepository->findAll();
    require __DIR__ . '/../view/genres/index.phtml';
}

public function genreCreate()
{
    if (isset($_POST['name'])) {
        if (empty(trim($_POST['name']))) {
            $_SESSION['flash'] = '⚠️ Le nom ne peut pas être vide !';
            header('Location: ?route=genreCreate');
            exit;
        }

        $existing = $this->genreRepository->findByName($_POST['name']);

        if ($existing) {
            $_SESSION['flash'] = '⚠️ Cette catégorie existe déjà !';
            header('Location: ?route=genres');
            exit;
        }

        $genre = new Genre();
        $genre->setName($_POST['name']);
        $this->genreRepository->add($genre);
        $_SESSION['flash'] = '✅ Catégorie ajoutée avec succès !';
        header('Location: ?route=genres');
        exit;
    }

    require __DIR__ . '/../view/genres/create.phtml';
}

public function genreUpdate()
{
    $id = (int)$_GET['id'];
    $genre = $this->genreRepository->findById($id);

    if (isset($_POST['name'])) {
        $genre->setName($_POST['name']);
        $this->genreRepository->update($id, $genre);
        $_SESSION['flash'] = '✅ Catégorie modifiée avec succès !';
        header('Location: ?route=genres');
        exit;
    }

    require __DIR__ . '/../view/genres/update.phtml';
}

public function genreDelete()
{
    $id = (int)$_GET['id'];
    $this->genreRepository->delete($id);
    $_SESSION['flash'] = '✅ Catégorie supprimée avec succès !';
    header('Location: ?route=genres');
    exit;
}

public function addFromTmdb()
{
    $tmdbId = (int)$_GET['id'];

    $existingFilm = $this->filmRepository->findByTmdbId($tmdbId, $this->userId);
    if ($existingFilm) {
        $_SESSION['flash'] = '⚠️ Ce film est déjà dans votre vidéothèque !';
        header('Location: ?route=show&id=' . $existingFilm->getId());
        exit;
    }

    $filmData = $this->tmdb->getFilmByTmdbId($tmdbId);

    $film = new Film();
    $film->setTmdb_id($filmData['id']);
    $film->setTitle($filmData['title']);
    $film->setPoster_path($filmData['poster_path']);
    $film->setRelease_date(!empty($filmData['release_date']) ? $filmData['release_date'] : null);
    $film->setRuntime($filmData['runtime'] ?? 0);
    $film->setOverview($filmData['overview'] ?: '');
    $film->setIsWatched(false);

    $this->filmRepository->add($film, $this->userId);

    $_SESSION['flash'] = '✅ Film ajouté à la vidéothèque !';
    header('Location: ?route=index');
    exit;
}
    public function searchApi(): void
{
    header('Content-Type: application/json');

    $query = trim($_GET['query'] ?? '');

    if (empty($query)) {
        echo json_encode([]);
        exit;
    }

    $results = $this->tmdb->getFilmByTmdbSearch($query);
    echo json_encode($results['results'] ?? []);
    exit;
}

    public function addFromTmdbApi(): void
    {
    header('Content-Type: application/json');

    $tmdbId = (int)($_GET['id'] ?? 0);

    if (!$tmdbId) {
        echo json_encode(['success' => false, 'message' => 'ID invalide.']);
        exit;
    }

    $existingFilm = $this->filmRepository->findByTmdbId($tmdbId, $this->userId);
    if ($existingFilm) {
        echo json_encode(['success' => false, 'message' => '⚠️ Film déjà dans votre vidéothèque !']);
        exit;
    }

    $filmData = $this->tmdb->getFilmByTmdbId($tmdbId);

    $film = new Film();
    $film->setTmdb_id($filmData['id']);
    $film->setTitle($filmData['title']);
    $film->setPoster_path($filmData['poster_path']);
    $film->setRelease_date(!empty($filmData['release_date']) ? $filmData['release_date'] : null);
    $film->setRuntime($filmData['runtime'] ?? 0);
    $film->setOverview($filmData['overview'] ?: '');
    $film->setIsWatched(false);

    $this->filmRepository->add($film, $this->userId);

    echo json_encode(['success' => true, 'message' => '✅ Film ajouté à la vidéothèque !']);
    exit;
}

    public function filmsApi(): void
    {
    header('Content-Type: application/json');

    $films = $this->filmRepository->findAll($this->userId);

    $data = array_map(function($film) {
        return [
            'id'           => $film->getId(),
            'title'        => $film->getTitle(),
            'poster_path'  => $film->getPoster_path(),
            'release_date' => $film->getRelease_date(),
            'genre_id'     => $film->getGenre_id(),
            'isWatched'    => $film->getIsWatched(),
        ];
    }, $films);

    echo json_encode($data);
    exit;
}  
private function checkFilmOwnership(Film $film): void
{
    if ($_SESSION['user_role'] !== 'admin' && $film->getUser_id() !== $this->userId) {
        $_SESSION['flash'] = '⛔ Vous n\'êtes pas autorisé à accéder à ce film.';
        header('Location: ?route=index');
        exit;
    }
}

}