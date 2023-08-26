<?php

namespace App\Http\Resources\Movies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
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
            "backdrops" => array_map(function ($backdrop) use ($img_url) {
                $backdrop["file_path"] = $img_url . $backdrop["file_path"];
                return $backdrop;
            }, $this["backdrops"]),
            "posters" => array_map(function ($poster) use ($img_url) {
                $poster["file_path"] = $img_url . $poster["file_path"];
                return $poster;
            }, $this["posters"]),
            "logos" => array_map(function ($logo) use ($img_url) {
                $logo["file_path"] = $img_url . $logo["file_path"];
                return $logo;
            }, $this["logos"])
        ];
        return $data;
    }
}
