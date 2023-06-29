<?php

namespace App\Http\Controllers;

use App\Events\UserFeedBack;
use App\Events\UserLiked;
use App\Events\UserUnLiked;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Like;
use App\Models\Notification;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request)
    {

        $validated = $request->validated();

        $like = Like::create($validated);

        $notification = Notification::create($validated);

        event(new UserLiked($like));

        $payload = (object)[
            'to' =>  $notification->author_id,
            'from' => auth('sanctum')->user()->username,
            'notification' =>  new NotificationResource($notification)
        ];

        event(new UserFeedBack($payload));


        return response()->json(['like' => $like], 201);
    }

    public function destroy(Like $like)
    {

        event(new UserUnLiked(['unlike' => $like]));

        $like->delete();

        return response()->json(['message' => 'like deleted succesfully', 200]);
    }


}
