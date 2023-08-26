<?php

use App\Http\Controllers\Api\CastController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "v1"], function () {
    Route::controller(MovieController::class)->group(function () {
        Route::get("movies/{id}/detail", "detail");                         // GET Movie Detail
        Route::get("movies/{id}/detail/images", "detailImage");             // GET Movie's Images
        Route::get("movies/{id}/detail/videos", "detailVideo");             // GET Movie's Videos
        Route::get("movies/{id}/detail/casts", "detailCasts");              // GET Movie's Casts
        Route::get("movies/{id}/recommendation", "recommendation");         // GET Recommendation Movies
        Route::get("movies/upcoming", "upcoming");                          // GET Upcoming Movies
        Route::get("movies/{id}/similar", "similar");                       // GET Similar Movies
        Route::get("movies/{id}/related", "related");                       // GET Related Movies
        Route::get("movies/popular", "popular");                            // GET Popular Movies
        Route::get("movies/discover", "discover");                          // GET Discover Movies
        Route::get("movies/top_rated", "topRated");                         // GET Top Rated Movies
        Route::get("movies/now_playing", "nowPlaying");                     // GET Now Playing Movies
        Route::get("movies/trending/all/{time}", "Trending");               // GET Trending Movies and TV by day or week
        Route::get("movies/trending/{time}", "TrendingMovies");             // GET Trending Movies by day or week
        Route::get("movies/trending/tv/{time}", "TrendingTV");              // GET Trending TV by day or week
        Route::get("movies/latest", "latest");                              // GET Latest Movies
        Route::get("movies/search", "search");                              // GET Search Movies
        Route::get("/movies/genres", "genres");                             // GET Genres
    });
    Route::get("/casts", [CastController::class, "index"]);
    Route::get("/casts/{id}", [CastController::class, "show"]);
});
