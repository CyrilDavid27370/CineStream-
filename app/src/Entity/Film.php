<?php

namespace Cine\App\Entity;

class Film
{
  private $id;
  private $tmdb_id;
  private $title;
  private $release_date;
  private $runtime;
  private $overview;
  private $genre_id;
  private $description;
  private $is_Watched;

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
   * Get the value of is_Watched
   */ 
  public function getIs_Watched()
  {
    return $this->is_Watched;
  }

  /**
   * Set the value of is_Watched
   *
   * @return  self
   */ 
  public function setIs_Watched($is_Watched)
  {
    $this->is_Watched = $is_Watched;

    return $this;
  }
}