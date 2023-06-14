<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(Request $request)
    {

        return response()->json(['movies' => Movie::all()]);
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


}
