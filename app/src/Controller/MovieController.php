<?php

namespace Cine\App\Controller;

use Cine\App\Entity\Genre;
use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;


class MovieController
{
  private $genreRepository;
  private $filmRepository;

  public function __construct()
  {
    $this->genreRepository = new GenreRepository;
    $this->filmRepository = new FilmRepository;
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

  }

  public function delete()
  {

  }
  
  public function search()
  {

  }

  public function showTmdb()
  {
    
  }

}

