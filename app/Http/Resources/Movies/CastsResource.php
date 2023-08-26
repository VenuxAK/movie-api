<?php

namespace App\Http\Resources\Movies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CastsResource extends JsonResource
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
            "id" => $this["id"],
            "casts" => array_map(function ($cast) use ($img_url) {
                $cast["profile_path"] = $cast["profile_path"] ? $img_url . $cast["profile_path"] : NULL;
                return $cast;
            }, $this["cast"]),
            "crews" => array_map(function ($crew) use ($img_url) {
                $crew["profile_path"] = $crew["profile_path"] ? $img_url . $crew["profile_path"] : NULL;
                return $crew;
            }, $this["crew"]),
        ];
        return $data;
    }
}

/*
{
      "adult": false,
      "gender": 1,
      "id": 90633,
      "known_for_department": "Acting",
      "name": "Gal Gadot",
      "original_name": "Gal Gadot",
      "popularity": 127.329,
      "profile_path": "/AbXKtWQwuDiwhoQLh34VRglwuBE.jpg",
      "cast_id": 1,
      "character": "Rachel Stone",
      "credit_id": "5f0cbd1113a3200036746c3c",
      "order": 0
    },

*/
