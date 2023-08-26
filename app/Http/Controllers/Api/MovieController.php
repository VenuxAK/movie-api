<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HttpRequest;
use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use HttpResponse, HttpRequest;

    public function detail($id)
    {
        $response = $this->request("movie/$id");
        return $response->ok() ?
            $this->successDetail($response->json(), "Movie detail") :
            $this->error($response->json());
    }

    public function detailImage($id)
    {
        $response = $this->request("movie/$id/images");
        // dd($response->json());
        return $response->ok() ?
            $this->successDetailImages($response->json(), "Movie detail images") :
            $this->error($response->json());
    }

    public function detailVideo($id)
    {
        $response = $this->request("movie/$id/videos");
        return $response->ok() ?
            $this->successDetailVideos($response->json(), "Movie detail trailers") :
            $this->error($response->json());
    }

    // /movie/{movie_id}/credits
    public function detailCasts($id)
    {
        $response = $this->request("movie/$id/credits");
        return $response->ok() ?
            $this->successDetailCastAndCrew($response->json(), "Movie detail cast and crew") :
            $this->error($response->json());
    }

    // movie/{movie_id}/recommendations
    public function recommendation($id)
    {
        $response = $this->request("movie/$id/recommendations");
        return $response->ok() ?
            $this->success($response->json(), "Recommendation movies list") :
            $this->error($response->json());
    }
    // movie/{movie_id}/similar
    public function similar($id)
    {
        $response = $this->request("movie/$id/similar");
        return $response->ok() ?
            $this->success($response->json(), "Similar movies list") :
            // $this->error($response->json());

            response()->json([
                "message" => "There is no related movies",
                // "success" => false,
                // "errors" => [
                //     "statusCode" => 404,
                //     "statusMessage" => "Not Found",
                // ],
            ]);
    }

    // collection/{collection_id}
    public function related($id)
    {
        $response = $this->request("collection/$id");
        return $response->ok() ?
            $this->successCollections($response->json(), "Related movies list") :
            $this->error($response->json());
    }
    // movie/popular
    public function popular()
    {
        $response = $this->request("movie/popular");
        return !$response->ok() ?
            $this->error($response->json()) :
            $this->success($response->json(), "Popular movies lists");
    }

    // discover/movie
    public function discover()
    {
        $response = $this->request("discover/movie");
        return $response->ok() ?
            $this->success($response->json(), "Discover movies lists") :
            $this->error($response->json());
    }

    // movie/top_rated
    public function topRated()
    {
        $response = $this->request("movie/top_rated");
        return $response->ok() ?
            $this->success($response->json(), "Top rated movies lists") :
            $this->error($response->json());
    }

    // movie/upcoming
    public function upcoming()
    {
        $response = $this->request("movie/upcoming");
        return $response->ok() ?
            $this->success($response->json(), "Upcoming movies lists") :
            $this->error($response->json());
    }

    // movie/now_playing
    public function nowPlaying()
    {
        $response = $this->request("movie/now_playing");
        return $response->ok() ?
            $this->success($response->json(), "Now playing movies lists") :
            $this->error($response->json());
    }

    // trending/all/day
    public function Trending(Request $request)
    {
        // dd($request->page);
        $page = $request->page ?? 1;
        $response = $this->request("trending/all/day" . "?page=" . $page);
        return $response->ok() ?
            $this->success($response->json(), "Trending movies and tv lists") :
            $this->error($response->json());
    }

    // trending/movies/{day or week}
    public function TrendingMovies(Request $request, $time)
    {
        $page = $request->page ?? 1;
        if ($time === "day" || $time === "week") {
            $response = $this->request("trending/movie/$time" . "?page=" . $page);
            return $response->ok() ?
                $this->success($response->json(), "Trending movies lists") :
                $this->error($response->json());
        } else {
            return response()->json(["message" => "Filter only for day and week"], 303);
        }
    }

    // trending/movies/{day or week}
    public function TrendingTV(Request $request, $time)
    {
        if ($time === "day" || $time === "week") {
            $response = $this->request("trending/tv/$time");
            return $response->ok() ?
                $this->success($response->json(), "Trending TV lists") :
                $this->error($response->json());
        } else {
            return response()->json(["message" => "Filter only for day and week"], 303);
        }
    }

    // movie/latest
    public function latest()
    {
        $response =  $this->request("movie/latest");
        return $response->ok() ?
            $this->successLatest($response->json(), "Latest movie") :
            $this->error($response->json());
    }

    // search/movie?include_adult=false&language=en-US&page=1
    public function search(Request $request)
    {
        $query = $request["query"];
        $response = $this->request("search/movie?query=$query&include_adult=false");
        $dataResponse = $response->json();
        $filteredData = array_filter($dataResponse["results"], function ($movie) {
            if ($movie["poster_path"] !== null && $movie["vote_average"] > 5) {
                return $movie;
            }
        });
        $data = count($dataResponse['results']) !== 0 ? MovieResource::collection($filteredData) : null;
        $statusCode = $data ? 200 : 404;

        // return Genre::all();
        return response()->json([
            "statusCode" => $statusCode,
            "statusMessage" => $data ? "OK" : "Not Found",
            "message" => $data ? "Searched movies lists" : "No movie found",
            "page" => $dataResponse["page"],
            "total_pages" => $dataResponse["total_pages"],
            "total_results" => $dataResponse["total_results"],
            "data"   => $data,
        ], $statusCode);
    }

    // genre/movie/list
    public function genres()
    {
        // genre/movie/list
        $response = $this->request("genre/movie/list");
        return $response->ok() ?
            $this->success($response->json(), "Genres list") :
            $this->error($response->json());
    }
}
