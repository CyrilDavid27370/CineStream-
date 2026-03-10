<?php

namespace Cine\app\Controller;


class MovieController
{
  private $genreRepository;
  private $filmRepository;

  public function __construct()
  {
    
  }
  
  public function index() 
  {
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

