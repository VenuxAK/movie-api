<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;


trait HttpRequest
{
    use HttpResponse, NetworkErrorHandler;
    protected function endpoint($uri, $lang = false)
    {
        $setLang = $lang ? "?language=en-US" : "";
        return config("tmdb.endpoint") . $uri . $setLang;
    }

    protected function request($uri, $setLang = false)
    {
        return Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . config("tmdb.api_auth")
        ])->timeout(30)->get($this->endpoint($uri, $setLang));
    }
}
