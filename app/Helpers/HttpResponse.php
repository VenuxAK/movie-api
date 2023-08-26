<?php

namespace App\Helpers;

use App\Http\Resources\Casts\CastResource;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\Movies\CastsResource;
use App\Http\Resources\Movies\DetailResource;
use App\Http\Resources\Movies\ImagesResource;
use App\Http\Resources\Movies\VideosResource;
use App\Models\Genre;

trait HttpResponse
{
    protected function success($movies, $message = null)
    {
        $data = count($movies['results']) !== 0 ? MovieResource::collection($movies['results']) : null;
        $statusCode = $data ? 200 : 404;
        if ($movies) {
            // return Genre::all();
            return response()->json([
                "statusCode" => $statusCode,
                "statusMessage" => $data ? "OK" : "Not Found",
                "message" => $data ? $message : "No movie found",
                "page" => $movies["page"],
                "total_pages" => $movies["total_pages"],
                "total_results" => $movies["total_results"],
                "data"   => $data,
            ], $statusCode);
        }
    }

    protected function successLatest($movies, $message = null)
    {
        if ($movies) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => $movies["page"] ?? null,
                "total_pages" => $movies["total_pages"] ?? null,
                "total_results" => $movies["total_results"] ?? null,
                "data"   => $movies['results'] ?? $movies,
            ]);
        }
    }

    protected function successDetail($movie, $message = null)
    {
        if ($movie) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => 1,
                "data"   => new DetailResource($movie),
            ]);
        }
    }

    protected function successDetailImages($movie, $message = null)
    {
        if ($movie) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => 1,
                "data" => new ImagesResource($movie),
            ]);
        }
    }

    protected function successDetailVideos($movie, $message = null)
    {
        if ($movie) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => 1,
                "id" => $movie["id"],
                "data" => new VideosResource($movie["results"] ?? $movie),
            ]);
        }
    }

    protected function successDetailCastAndCrew($movie, $message = null)
    {
        if ($movie) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => 1,
                "id" => $movie["id"],
                "data" => new CastsResource($movie["results"] ?? $movie),
            ], 200);
        }
    }

    protected function successCollections($movie, String $message = null)
    {
        if ($movie) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => 1,
                "id" => $movie["id"],
                "data" => new CollectionResource($movie)
            ], 200);
        }
    }

    protected function successCasts($casts, $message = null)
    {
        if ($casts) {
            return response()->json([
                "statusCode" => 200,
                "statusMessage" => "OK",
                "message" => $message,
                "page" => $casts["page"] ?? null,
                "total_pages" => $casts["total_pages"] ?? null,
                "total_results" => $casts["total_results"] ?? null,
                "data" => new CastResource($casts)
            ], 200);
        }
    }

    protected function error($logs = [])
    {
        $notFound = $logs["status_code"] == 34 ? 404 : null;
        $invalid = $logs["status_code"] == 6 ? 400 : null;
        $notFoundMessage = $notFound ? "Not Found" : null;
        $invalidMessage = $invalid ? "Bad Request" : null;

        $statusCode = $notFound ?? $invalid;
        $statusMessage = $notFoundMessage ?? $invalidMessage;
        return response()->json([
            "message" => "Error Occur",
            "success" => $logs["success"],
            "errors" => [
                "statusCode" => $statusCode,
                "statusMessage" => $statusMessage,
            ],
            "raw_errors" => $logs
        ], $statusCode);
    }
}
