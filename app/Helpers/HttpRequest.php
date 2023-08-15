<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;


trait HttpRequest
{
    use HttpResponse, NetworkErrorHandler;
    protected function endpoint($uri, $lang = true)
    {
        $setLang = $lang ? "?language=en-US" : "";
        return config("tmdb.endpoint") . $uri . $setLang;
    }

    protected function fetchMovies($uri)
    {
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . config("tmdb.api_auth")
        ])->timeout(10)->get($this->endpoint($uri, false));
        return $response;
    }

    protected function fetchMovieDetail($uri)
    {
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . config("tmdb.api_auth")
        ])->timeout(10)->get($this->endpoint($uri, false));
        return $response;
    }
}
