<?php

use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "v1"], function () {
    Route::controller(MovieController::class)->group(function () {
        Route::get("movies/{id}/detail", "detail");
        Route::get("movies/{id}/detail/images", "detailImage");
        Route::get("movies/{id}/detail/videos", "detailVideo");
        Route::get("movies/{id}/recommendation", "recommendation");
        Route::get("movies/{id}/similar", "similar");
        Route::get("movies/popular", "popular");
        Route::get("movies/discover", "discover");
        Route::get("movies/top_rated", "topRated");
        Route::get("movies/now_playing", "nowPlaying");
        Route::get("movies/trending", "TrendingMoviesToday");
        Route::get("movies/trending/all", "Trending");
        Route::get("movies/trending/tv", "TrendingTvToday");
        Route::get("movies/latest", "latest");
        Route::get("movies/search", "search");
    });
});
