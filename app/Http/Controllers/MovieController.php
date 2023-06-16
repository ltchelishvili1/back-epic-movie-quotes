<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {

        return response()->json(['movies' => Movie::where('user_id', auth()->user()->id)->get()]);
    }

    public function store(StoreMovieRequest $request)
    {

        $validated = $request->validated();
        $thumbnail = null;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('movie-image');

            $thumbnail = url('storage/' . $path);
        }

        $movie = Movie::updateOrCreate([
            'director' => $validated['director'],
            'title' => $validated['title'],
            'user_id' => auth()->user()->id,
            'release_year' => $validated['release_year'],
            'image' => $thumbnail,
            'description' => $validated['description']
        ]);


        $movie->genres()->attach(json_decode($validated['genres']));


        return response()->json(['movie' => $movie], 200);
    }

    public function choose(Movie $movie): JsonResponse
    {
        if ($movie->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

        return response()->json(['movie' => $movie], 200);
    }


    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $validated = $request->validated();
        $thumbnail = $movie->image;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('movie-image');

            $thumbnail = url('storage/' . $path);
        }

        $movie->update([
            'director' => $validated['director'],
            'title' => $validated['title'],
            'user_id' => auth()->user()->id,
            'release_year' => $validated['release_year'],
            'image' => $thumbnail,
            'description' => $validated['description']
        ]);

        $genres = json_decode($validated['genres']);
        $movie->genres()->sync($genres);


        return response()->json(['movie' => $movie], 200);

    }

    public function destroy(Movie $movie): JsonResponse
    {
        if ($movie->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie deleted succesfully'], 200);
    }


}
