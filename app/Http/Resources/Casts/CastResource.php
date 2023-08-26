<?php

namespace App\Http\Resources\Casts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = array_map(function ($cast) {
            return [
                "adult" => $cast["adult"],
                "gender" => $cast["gender"],
                "id" => $cast["id"],
                "known_for_department" => $cast["known_for_department"] ?? null,
                "name" => $cast["name"],
                "popularity" => $cast["popularity"],
                "profile_path" => $cast["profile_path"] ? config('tmdb.img_endpoint') . $cast["profile_path"] : NULL,
                "known_for" => array_map(function ($movie) {
                    return [
                        "id" => $movie["id"] ?? null,
                        "adult" => $movie["adult"] ?? null,
                        "title" => $movie["title"] ?? null,
                        "original_title" => $movie["original_title"] ?? null,
                        "original_language" => $movie["original_language"] ?? null,
                        "overview" => $movie["overview"] ?? null,
                        // "backdrop" => $movie["backdrop_path"] ? config('tmdb.img_endpoint') . $movie["backdrop_path"] : NULL,
                        // "poster" => $movie["poster_path"] ? config('tmdb.img_endpoint') . $movie["poster_path"] : NULL,
                        "media_type" => $movie["media_type"] ?? null,
                        "genres" => $movie["genre_ids"] ?? null,
                        "release_date" => $movie["release_date"] ?? null,
                        "video" => $movie["video"] ?? null,
                        "vote_average" => $movie["vote_average"] ?? null,
                        "vote_count" => $movie["vote_count"] ?? null
                    ];
                }, $cast["known_for"])

            ];
        }, $this["results"]);
        return $data;
    }
}

/**
 *
 * "adult": false,
            "gender": 1,
            "id": 169337,
            "known_for": [
                {
                    "adult": false,
                    "backdrop_path": "/3gsn2rViobMWbyJ0M20Zpur20w0.jpg",
                    "genre_ids": [
                        35
                    ],
                    "id": 77953,
                    "media_type": "movie",
                    "original_language": "en",
                    "original_title": "The Campaign",
                    "overview": "Two rival politicians compete to win an election to represent their small North Carolina congressional district in the United States House of Representatives.",
                    "poster_path": "/jMWjJ13sFTT07DwjNlqh8VY4sK6.jpg",
                    "release_date": "2012-08-09",
                    "title": "The Campaign",
                    "video": false,
                    "vote_average": 5.8,
                    "vote_count": 1586
                },
            ],
            "known_for_department": "Acting",
            "name": "Katherine LaNasa",
            "popularity": 293.366,
            "profile_path": "/a1T5Smn7sCEtV8NHvTa5WaxgOML.jpg"
 */
