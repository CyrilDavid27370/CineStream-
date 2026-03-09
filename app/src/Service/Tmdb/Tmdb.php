<?php

namespace Cine\App\Service\Tmdb;

class Tmdb
{
    /** URL de base de l'API TMDB */
    const BASE_URL = "https://api.themoviedb.org/3";
    /** URL de base pour les affiches des films */
    const IMG_URL  = "https://image.tmdb.org/t/p/w300";

    /**
     * Recherche des films par titre sur TMDB
     */
    public function getFilmByTmdbSearch(string $search)
    {
        return $this->tmdb_get('/search/movie', ['query' => $search]);
    }
  
    /**
     * Récupère les détails d'un film par son identifiant TMDB
     */
    public function getFilmByTmdbId($id) : ?array
    {
        return $this->tmdb_get('/movie/' . (int)$id);
    }

    private function tmdb_get($endpoint, $params = []) 
    {
        global $API_KEY;
        $params['api_key']  = $API_KEY;
        $params['language'] = 'fr-FR';
        $url = self::BASE_URL . $endpoint . '?' . http_build_query($params);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}