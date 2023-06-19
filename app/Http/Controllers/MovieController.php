<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MovieController extends Controller
{
    public function index(Request $request)
    {

        return response()->json(['movies' => Movie::where('user_id', auth()->id())->get()]);
    }

    public function store(StoreMovieRequest $request)
    {

        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {

            $path = $request->file('thumbnail')->store('movie-thumbnail');

            $validated['thumbnail'] = url('storage/' . $path);
        }

        $movie = Movie::create($validated);

        $movie->genres()->attach(json_decode($validated['genres']));

        return response()->json(['movie' => $movie], 200);
    }

    public function show(Movie $movie): JsonResponse
    {
        $response = Gate::inspect('view', $movie);

        if (!$response->allowed()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }


        return response()->json(['movie' => $movie], 200);
    }


    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $validated = $request->validated();

        $validated['thumbnail'] = $movie->thumbnail;

        if ($request->hasFile('thumbnail')) {

            $path = $request->file('thumbnail')->store('movie-thumbnail');

            $validated['thumbnail'] = url('storage/' . $path);
        }

        $movie->update($validated);

        $genres = json_decode($validated['genres']);

        $movie->genres()->sync($genres);


        return response()->json(['movie' => $movie], 200);

    }

    public function destroy(Movie $movie): JsonResponse
    {
        $response = Gate::inspect('view', $movie);

        if (!$response->allowed()) {

            return response()->json(['message' => 'Not Authorized'], 401);

        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted succesfully'], 200);
    }


}
