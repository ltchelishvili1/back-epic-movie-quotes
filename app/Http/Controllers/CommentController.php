<?php

namespace App\Http\Controllers;

use App\Events\UserFeedBack;
use App\Events\UserLiked;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\NotificationResource;
use App\Models\Comment;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $validated =$request->validated();

        $comment = Comment::create($validated);

        $notification = Notification::create($validated);

        event(new UserLiked(['comment' => new CommentResource($comment)]));

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

        return response()->json(['message' => __('validation.comment_deleted_successfully'), 200]);
    }
}