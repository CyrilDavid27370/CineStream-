<?php

namespace Cine\App\Entity;

class Film
{
  private $id;
  private $tmdb_id;
  private $title;
  private $poster_path;
  private $release_date;
  private $runtime;
  private $overview;
  private $genre_id;
  private $description;
  private $isWatched;
  private $genre_name;
  private $rating;
  private $user_id;

  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of tmdb_id
   */ 
  public function getTmdb_id()
  {
    return $this->tmdb_id;
  }

  /**
   * Set the value of tmdb_id
   *
   * @return  self
   */ 
  public function setTmdb_id($tmdb_id)
  {
    $this->tmdb_id = $tmdb_id;

    return $this;
  }

  /**
   * Get the value of title
   */ 
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */ 
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of release_date
   */ 
  public function getRelease_date()
  {
    return $this->release_date;
  }

  /**
   * Set the value of release_date
   *
   * @return  self
   */ 
  public function setRelease_date($release_date)
  {
    $this->release_date = $release_date;

    return $this;
  }

  /**
   * Get the value of runtime
   */ 
  public function getRuntime()
  {
    return $this->runtime;
  }

  /**
   * Set the value of runtime
   *
   * @return  self
   */ 
  public function setRuntime($runtime)
  {
    $this->runtime = $runtime;

    return $this;
  }

  /**
   * Get the value of overview
   */ 
  public function getOverview()
  {
    return $this->overview;
  }

  /**
   * Set the value of overview
   *
   * @return  self
   */ 
  public function setOverview($overview)
  {
    $this->overview = $overview;

    return $this;
  }

  /**
   * Get the value of genre_id
   */ 
  public function getGenre_id()
  {
    return $this->genre_id;
  }

  /**
   * Set the value of genre_id
   *
   * @return  self
   */ 
  public function setGenre_id($genre_id)
  {
    $this->genre_id = $genre_id;

    return $this;
  }

  /**
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of poster_path
   */ 
  public function getPoster_path()
  {
    return $this->poster_path;
  }

  /**
   * Set the value of poster_path
   *
   * @return  self
   */ 
  public function setPoster_path($poster_path)
  {
    $this->poster_path = $poster_path;

    return $this;
  }

  /**
   * Get the value of isWatched
   */ 
  public function getIsWatched()
  {
    return $this->isWatched;
  }

  /**
   * Set the value of isWatched
   *
   * @return  self
   */ 
  public function setIsWatched($isWatched)
  {
    $this->isWatched = $isWatched;

    return $this;
  }

  /**
   * Get the value of genre_name
   */ 
  public function getGenre_name()
  {
    return $this->genre_name;
  }

  /**
   * Set the value of genre_name
   *
   * @return  self
   */ 
  public function setGenre_name($genre_name)
  {
    $this->genre_name = $genre_name;

    return $this;
  }

  /**
   * Get the value of rating
   */ 
  public function getRating()
  {
    return $this->rating;
  }

  /**
   * Set the value of rating
   *
   * @return  self
   */ 
  public function setRating($rating)
  {
    $this->rating = $rating;

    return $this;
  }

  /**
   * Get the value of user_id
   */ 
  public function getUser_id()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   *
   * @return  self
   */ 
  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }
}