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
    $films = [];

    require __DIR__ . '/../view/films/index.phtml';
  }

  public function show()
  {

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

