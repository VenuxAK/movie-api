<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $img_base_url = "https://image.tmdb.org/t/p/original";
        $data = [
            "id" => $this["id"],
            "name" => $this["name"],
            "overview" => $this["overview"],
            "poster_path" => $this["poster_path"] ? $img_base_url . $this["poster_path"] : NULL,
            "backdrop_path" => $this["backdrop_path"] ? $img_base_url . $this["backdrop_path"] : NULL,
            "parts" => array_map(function ($collection) use ($img_base_url) {
                return [
                    "adult" => $collection["adult"],
                    "id" => $collection["id"],
                    "title" => $collection["title"],
                    "original_language" => $collection["original_language"],
                    "overview" => $collection["overview"],
                    "backdrop" => $collection["backdrop_path"] ? $img_base_url . $collection["backdrop_path"] : NULL,
                    "poster" => $collection["poster_path"] ? $img_base_url . $collection["poster_path"] : NULL,
                    "media_type" => $collection["media_type"],
                    "genres" => $collection["genre_ids"],
                    "popularity" => $collection["popularity"],
                    "release_date" => $collection["release_date"],
                    "video" => $collection["video"],
                    "vote_average" => $collection["vote_average"],
                    "vote_count" => $collection["vote_count"]
                ];
            }, $this["parts"]),
            // "parts" => [
            //     "adult" => $this["parts"]["adult"],
            //     "id" => $this["parts"]["id"],
            //     "title" => $this["parts"]["title"],
            //     "original_language" => $this["parts"]["original_language"],
            //     "overview" => $this["parts"]["overview"],
            //     "backdrop_path" => $this["parts"]["backdrop_path"],
            //     "poster_path" => $this["parts"]["poster_path"],
            //     "media_type" => $this["parts"]["media_type"],
            //     "genres" => $this["parts"]["genre_ids"],
            //     "popularity" => $this["parts"]["popularity"],
            //     "release_date" => $this["parts"]["release_date"],
            //     "video" => $this["parts"]["video"],
            //     "vote_average" => $this["parts"]["vote_average"],
            //     "vote_count" => $this["parts"]["vote_count"]
            // ]
        ];
        return $data;
    }
}

/**
 *
 * "adult": false,
      "backdrop_path": "/z3ioibdjWZOYeXjoiabFOFOfPI3.jpg",
      "id": 584,
      "title": "2 Fast 2 Furious",
      "original_language": "en",
      "original_title": "2 Fast 2 Furious",
      "overview": "It's a major double-cross when former police officer Brian O'Conner teams up with his ex-con buddy Roman Pearce to transport a shipment of \"dirty\" money for shady Miami-based import-export dealer Carter Verone. But the guys are actually working with undercover agent Monica Fuentes to bring Verone down.",
      "poster_path": "/6nDZExrDKIXvSAghsFKVFRVJuSf.jpg",
      "media_type": "movie",
      "genre_ids": [
        28,
        80,
        53
      ],
      "popularity": 7.793,
      "release_date": "2003-06-05",
      "video": false,
      "vote_average": 6.484,
      "vote_count": 6730
 */
