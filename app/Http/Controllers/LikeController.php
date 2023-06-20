<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $like = Like::updateOrCreate([
            'quote_id' => $request['quote_id'],
            'user_id' => auth()->user()->id
        ]);

        return response()->json($like);
    }

    public function destroy(Like $like)
    {
        $like->delete();
        return response()->json(['message' => 'like deleted succesfully', 200]);
    }


}
