<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HttpRequest;
use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CastController extends Controller
{
    use HttpRequest, HttpResponse;

    public function index()
    {
        // person/popular
        $response = $this->request("person/popular");
        $init_casts = $response->json();
        $casts = array_map(function ($cast) {
            return [
                "gender" => $cast["gender"],
                "id" => $cast["id"],
                "known_for_department" => $cast["known_for_department"] ?? null,
                "name" => $cast["name"],
                "popularity" => $cast["popularity"],
                "profile_path" => $cast["profile_path"] ? config('tmdb.img_endpoint') . $cast["profile_path"] : NULL,
            ];
        }, $init_casts["results"]);
        return $response->ok() ?
            response()->json($casts, 200) :
            $this->error($init_casts);
        // return $response->ok() ?
        //     $this->successCasts($casts, "Casts list") :
        //     $this->error($init_casts);
    }

    public function show($id)
    {
        // person/{person_id}
        // person/{person_id}/movie_credits
        // person/{person_id}/tv_credits

        // Cast Detail
        $responseCastDetail = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . config("tmdb.api_auth")
        ])->timeout(30)->get($this->endpoint("person/$id"));

        // Cast's Movies
        $responseCastMovies = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Bearer " . config("tmdb.api_auth")
        ])->timeout(30)->get($this->endpoint("person/$id/movie_credits"));

        $castDetail = $responseCastDetail->json();
        $castMovies = $responseCastMovies->json();

        $responseCast = [
            "id" => $castDetail["id"],
            "name" => $castDetail["name"],
            "birthday" => $castDetail["birthday"],
            "biography" => $castDetail["biography"],
            "deathday" => $castDetail["deathday"],
            "gender" => $castDetail["gender"],
            "homepage" => $castDetail["homepage"] ?? null,
            "known_for_department" => $castDetail["known_for_department"],
            "place_of_birth" => $castDetail["place_of_birth"],
            "popularity" => $castDetail["popularity"],
            "profile" => $castDetail["profile_path"] ? config('tmdb.img_endpoint') . $castDetail["profile_path"] : NULL,
            "also_known_as" => $castDetail["also_known_as"]
        ];

        $responseMovies = [
            "known_for" => array_map(function ($movie) {
                return [
                    "id" => $movie["id"],
                    "title" => $movie["title"] ?? NULL,
                    "original_title" => $movie["original_title"] ?? NULL,
                    "original_language" => $movie["original_language"] ?? NULL,
                    "overview" => $movie["overview"] ?? NULL,
                    "popularity" => $movie["popularity"] ?? NULL,
                    "poster" => $movie["poster_path"] ? config("tmdb.img_endpoint") . $movie["poster_path"] : NULL,
                    "release_date" => $movie["release_date"] ?? NULL,
                    "vote_average" => $movie["vote_average"] ?? NULL,
                    "vote_count" => $movie["vote_count"] ?? NULL,
                    "character" => $movie["character"] ?? NULL,
                    "credit_id" => $movie["credit_id"] ?? NULL,
                    "order" => $movie["order"] ?? NULL
                ];
            }, $castMovies["cast"])
        ];

        return $responseCastDetail->ok() && $responseCastMovies->ok() ?
            [
                ...$responseCast,
                'known_for' => array_filter($responseMovies['known_for'], function ($movie) {
                    return $movie["poster"] !== null && $movie["vote_average"] > 6 ? $movie : NULL;
                })
            ] :
            $responseCastDetail->json() ?? $responseCastMovies->json();
    }
}
/**
 *
 * "adult": false,
    "backdrop_path": "/QCyGrineEEOy88bcPrLEquG18j.jpg",
    "genre_ids": [
        35
    ],
    "id": 314041,
    "original_language": "he",
    "original_title": "שושנה חלוץ מרכזי",
    "overview": "In the conservative city of Jerusalem, Ami Shoshan, an Israeli football player, is forced by a mafia boss to pose as a homosexual, a punishment for flirting with the criminal's girlfriend. Shoshan is banned by players and fans of his team, but becomes a hero of the gay community.",
    "popularity": 4.326,
    "poster_path": "/cHjNixfOq1vD4lFNedIIP36LdOn.jpg",
    "release_date": "2014-07-17",
    "title": "Kicking Out Shoshana",
    "video": false,
    "vote_average": 5.289,
    "vote_count": 19,
    "character": "Mirit Ben Harush",
    "credit_id": "549eefcac3a3682f1e008693",
    "order": 0
 */
