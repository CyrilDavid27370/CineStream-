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

  public function __construct()
  {
    $this->genreRepository = new GenreRepository;
    $this->filmRepository = new FilmRepository;
    $this->tmdb = new Tmdb;
  }
  
  public function index() 
  {
    $genres = $this->genreRepository->findAll();

  if (isset($_GET['genre'])) {
    if ($_GET['genre'] === 'nc') {
        $films = $this->filmRepository->findByNoGenre();
    } else {
        $films = $this->filmRepository->findByGenre((int)$_GET['genre']);
    }

    } elseif (isset($_GET['filter']) && $_GET['filter'] === 'watched') {
    $films = $this->filmRepository->findByWatched(true);
    } elseif (isset($_GET['filter']) && $_GET['filter'] === 'towatch') {
    $films = $this->filmRepository->findByWatched(false);
    } else {
    $films = $this->filmRepository->findAll();
}
    require __DIR__ . '/../view/films/index.phtml';
  }

  public function show()
  {
    $id = (int)$_GET['id'];
    $film = $this->filmRepository->findById($id);

    require __DIR__ . '/../view/films/show.phtml';
  }

  public function update()
  {
      $id = (int)$_GET['id'];
      $film = $this->filmRepository->findById($id);
      $genres = $this->genreRepository->findAll();

      if(isset($_POST['genre_id'])) {
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
    $this->filmRepository->delete($id);

    header('location: ?route=index');
    exit;
  }
  
  public function search()
  {
    $films = [];

    if(isset($_GET['query']) && !empty($_GET['query'])) {
      $results = $this->tmdb->getFilmByTmdbSearch($_GET['query']);
      $films = $results['results'];
    }

    require __DIR__ . '/../view/films/search.phtml';

  }

  public function showTmdb()
  {
    $film = $this->tmdb->getFilmByTmdbId((int)$_GET['id']);

    require __DIR__ . '/../view/films/showTmdb.phtml';

  }

  public function addFromTmdb() 
  {
    $tmdbId = (int)$_GET['id'];

    $existingFilm = $this->filmRepository->findByTmdbId($tmdbId);
      if ($existingFilm) {
          $_SESSION['flash'] = '⚠️ Ce film est déjà dans votre vidéothèque !';
        header('Location: ?route=show&id=' . $existingFilm->getId());
        exit;
    }
    $filmData = $this->tmdb->getFilmByTmdbId($tmdbId);

    $film = new Film;
    $film->setTmdb_id($filmData['id']);
    $film->setTitle($filmData['title']);
    $film->setPoster_path($filmData['poster_path']);
    $film->setRelease_date(!empty($filmData['release_date']) ? $filmData['release_date'] : null);
    $film->setRuntime($filmData['runtime'] ?? 0);
    $film->setOverview($filmData['overview'] ? : '');
    $film->setIsWatched(false);

    $this->filmRepository->add($film);

    $_SESSION['flash'] = '✅ Film ajouté à la vidéothèque !';

    header('Location: ?route=index');
    exit;

  }

}

