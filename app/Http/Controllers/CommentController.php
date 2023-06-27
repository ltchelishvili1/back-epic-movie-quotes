<?php

namespace App\Http\Controllers;

use App\Events\UserFeedBack;
use App\Events\UserLiked;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $validated =$request->validated();

        $comment = Comment::create($validated);

        $notification = Notification::create([
            'user_id' => auth()->user()->id,
            'author_id' => Quote::find($validated['quote_id'])->user_id,
            'has_user_seen' => false,
            'type' => 'comment'
        ]);


        event(new UserLiked(['comment' => $comment]));


        $payload = (object)[
            'to' =>  $notification->author_id,
            'from' => auth('sanctum')->user()->username,
            'notification' => new NotificationResource($notification)
        ];

        event(new UserFeedBack($payload));


        return response()->json(['comment' => $comment], 201);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'comment deleted succesfully', 200]);
    }
}
