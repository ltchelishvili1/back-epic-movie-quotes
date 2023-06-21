<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikeRequest;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request)
    {
        $like = Like::updateOrCreate($request->validated());

        return response()->json($like);
    }

    public function destroy(Like $like)
    {

        $like->delete();

        return response()->json(['message' => 'like deleted succesfully', 200]);
    }


}
