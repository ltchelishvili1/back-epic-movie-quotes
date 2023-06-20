<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = Comment::updateOrCreate([
            'quote_id' => $request['quote_id'],
            'user_id' => auth()->user()->id,
            'comment' => $request['comment']
        ]);

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        if (json_decode(request()->user_id) !== auth()->id()) {
            return response()->json(['message' => 'Not Authorized'], 401);
        }

        $comment->delete();
        return response()->json(['message' => 'comment deleted succesfully', 200]);
    }
}
