<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [
            "id" => $this["id"] ?? null,
            "title" => $this["title"] ?? null,
            "original_title" => $this["original_title"] ?? null,
            "name" => $this["name"] ?? null,
            "original_name" => $this["original_name"] ?? null,
            "overview" => $this["overview"] ?? null,
            "original_language" => $this["original_language"] ?? null,
            "origin_country" => $this["origin_country"] ?? null,
            "backdrop" => $this["backdrop_path"] ? "https://image.tmdb.org/t/p/original" . $this["backdrop_path"] : null,
            "poster" => $this["poster_path"] ? "https://image.tmdb.org/t/p/original" . $this["poster_path"] : null,
            "media_type" => $this["media_type"] ?? null,
            "genre_ids" => $this["genre_ids"] ?? null,
            "adult" => $this["adult"] ?? null,
            "popularity" => $this["popularity"] ?? null,
            "vote_average" => $this["vote_average"] ?? null,
            "vote_count" => $this["vote_count"] ?? null,
            "release_date" => $this["release_date"] ?? null,
            "first_air_date" => $this["first_air_date"] ?? null,
            "video" => $this["video"] ?? null,

        ];
        if (count($data) > 0) {
            return $data;
        }
        return [
            "results" => "Not Found Movie"
        ];
    }
}
// {
//   "adult": false,
//   "backdrop_path": null,
//   "belongs_to_collection": null,
//   "budget": 0,
//   "genres": [
//     {
//       "id": 35,
//       "name": "Comedy"
//     }
//   ],
//   "homepage": "",
//   "id": 1164937,
//   "imdb_id": "tt1900869",
//   "original_language": "pt",
//   "original_title": "Estranhos",
//   "overview": "",
//   "popularity": 0,
//   "poster_path": null,
//   "production_companies": [
//     {
//       "id": 206222,
//       "logo_path": null,
//       "name": "Araça Azul Cinema e Video",
//       "origin_country": ""
//     }
//   ],
//   "production_countries": [],
//   "release_date": "2010-05-04",
//   "revenue": 0,
//   "runtime": 0,
//   "spoken_languages": [
//     {
//       "english_name": "Portuguese",
//       "iso_639_1": "pt",
//       "name": "Português"
//     }
//   ],
//   "status": "Released",
//   "tagline": "",
//   "title": "Estranhos",
//   "video": false,
//   "vote_average": 0,
//   "vote_count": 0
// }
