<?php

namespace App\Http\Resources\Movies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $img_url = "https://image.tmdb.org/t/p/original";
        $data = [
            "adult" => $this["adult"],
            "backdrop_path" => $img_url . $this["backdrop_path"],
            "belongs_to_collection" => $this["belongs_to_collection"] ? [
                "id" => $this["belongs_to_collection"]["id"],
                "name" => $this["belongs_to_collection"]["name"],
                "poster_path" => $img_url . $this["belongs_to_collection"]["poster_path"],
                "backdrop_path" => $img_url . $this["belongs_to_collection"]["backdrop_path"],
            ] : null,
            "budget" => $this["budget"],
            "genres" => $this["genres"],
            "homepage" => $this["homepage"],
            "id" => $this["id"],
            "imdb_id" => $this["imdb_id"],
            "original_language" => $this["original_language"],
            "original_title" => $this["original_title"],
            "overview" => $this["overview"],
            "popularity" => $this["popularity"],
            "poster_path" => $img_url . $this["poster_path"],
            "production_countries" => $this["production_countries"],
            "production_companies" => array_map(function ($cmp) use ($img_url) {
                if ($cmp["logo_path"] !== null) {
                    $cmp["logo_path"] = $img_url . $cmp["logo_path"];
                }
                return $cmp;
            }, $this["production_companies"]),
            "release_date" => $this["release_date"],
            "revenue" => $this["revenue"],
            "runtime" => $this["runtime"],
            "spoken_languages" => $this["spoken_languages"],
            "status" => $this["status"],
            "tagline" => $this["tagline"],
            "title" => $this["title"],
            "video" => $this["video"],
            "vote_average" => $this["vote_average"],
            "vote_count" => $this["vote_count"]
        ];
        return $data;
    }
}
