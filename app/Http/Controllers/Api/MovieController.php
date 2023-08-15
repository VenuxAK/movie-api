<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HttpRequest;
use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use HttpResponse, HttpRequest;

    public function detail($id)
    {
        $response = $this->fetchMovieDetail("movie/$id");
        return $response->ok() ?
            $this->successDetail($response->json(), "Movie detail") :
            $this->error($response->json());
    }

    public function detailImage($id)
    {
        $response = $this->fetchMovieDetail("movie/$id/images");
        // dd($response->json());
        return $response->ok() ?
            $this->successDetailImages($response->json(), "Movie detail images") :
            $this->error($response->json());
    }

    public function detailVideo($id)
    {
        $response = $this->fetchMovieDetail("movie/$id/videos");
        return $response->ok() ?
            $this->successDetailVideos($response->json(), "Movie detail trailers") :
            $this->error($response->json());
    }
    // movie/{movie_id}/recommendations
    public function recommendation($id)
    {
        $response = $this->fetchMovies("movie/$id/recommendations");
        return $response->ok() ?
            $this->success($response->json(), "Recommendation movies list") :
            $this->error($response->json());
    }
    // movie/{movie_id}/similar
    public function similar($id)
    {
        $response = $this->fetchMovies("movie/$id/similar");
        return $response->ok() ?
            $this->success($response->json(), "Similar movies list") :
            $this->error($response->json());
    }

    // movie/popular
    public function popular()
    {
        $response = $this->fetchMovies("movie/popular");
        return !$response->ok() ?
            $this->error($response->json()) :
            $this->success($response->json(), "Popular movies lists");
    }

    // discover/movie
    public function discover()
    {
        $response = $this->fetchMovies("discover/movie");
        return $response->ok() ?
            $this->success($response->json(), "Discover movies lists") :
            $this->error($response->json());
    }

    // movie/top_rated
    public function topRated()
    {
        $response = $this->fetchMovies("movie/top_rated");
        return $response->ok() ?
            $this->success($response->json(), "Top rated movies lists") :
            $this->error($response->json());
    }

    // movie/upcoming
    public function upcoming()
    {
        $response = $this->fetchMovies("movie/upcoming");
        return $response->ok() ?
            $this->success($response->json(), "Upcoming movies lists") :
            $this->error($response->json());
    }

    // movie/now_playing
    public function nowPlaying()
    {
        $response = $this->fetchMovies("movie/now_playing");
        return $response->ok() ?
            $this->success($response->json(), "Now playing movies lists") :
            $this->error($response->json());
    }

    // trending/all/day
    public function Trending()
    {
        $response = $this->fetchMovies("trending/all/day");
        return $response->ok() ?
            $this->success($response->json(), "Trending movies and tv lists") :
            $this->error($response->json());
    }

    // trending/movies/day
    public function TrendingMoviesToday()
    {
        $response = $this->fetchMovies("trending/movie/day");
        return $response->ok() ?
            $this->success($response->json(), "Trending movies lists") :
            $this->error($response->json());
    }

    // trending/tv/day
    public function TrendingTvToday()
    {
        $response = $this->fetchMovies("trending/tv/day");
        return $response->ok() ?
            $this->success($response->json(), "Trending tv lists") :
            $this->error($response->json());
    }

    // movie/latest
    public function latest()
    {
        $response =  $this->fetchMovies("movie/latest");
        return $response->ok() ?
            $this->successLatest($response->json(), "Latest movie") :
            $this->error($response->json());
    }

    // search/movie?include_adult=false&language=en-US&page=1
    public function search(Request $request)
    {
        $query = $request["query"];
        $response = $this->fetchMovies("search/movie?query=$query&include_adult=false");
        return $response->ok() ?
            $this->success($response->json(), "Searched movies list") :
            $this->error($response->json());
    }
}
