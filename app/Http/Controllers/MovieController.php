<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieNameResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request)
    {
        if(isset($request['searchKey'])) {

            $movies = Movie::search($request['searchKey'])
            ->orderByDesc('id')
            ->simplePaginate(6);

            return response()->json(['movies' => MovieResource::collection($movies)], 200);

        }

        return response()->json(['movies' =>  MovieResource::collection(Movie::all())]);
    }

    public function store(StoreMovieRequest $request)
    {

        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {

            $validated['thumbnail'] = $this->fileUploadService->uploadFile($request->file('thumbnail'), 'movie-thumbnail');

        }

        $movie = Movie::create($validated);

        $movie->genres()->attach(json_decode($validated['genres']));

        return response()->json(['movie' => $movie], 200);
    }

    public function show(Movie $movie): JsonResponse
    {
        return response()->json(['movie' => new MovieResource($movie)], 200);
    }


    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {

        $validated = $request->validated();

        $validated['thumbnail'] = $movie->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $validated['thumbnail'] = $this->fileUploadService->uploadFile($request->file('thumbnail'), 'movie-thumbnail');

        }

        $movie->update($validated);

        $genres = json_decode($validated['genres']);

        $movie->genres()->sync($genres);


        return response()->json(['movie' => $movie], 200);

    }

    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json(['message' => __('validation.movie_deleted_successfully')], 200);
    }


}
