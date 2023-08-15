<?php

namespace App\Http\Resources\Movies;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $video_url = "https://youtu.be/";
        $video_url = "https://www.youtube.com/watch?v=";
        $data = array_map(function ($source) use ($video_url) {
            $source["url"] = $video_url . $source["key"];
            return $source;
        }, $this->resource);
        return $data;
    }
}
