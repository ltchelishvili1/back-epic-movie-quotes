<?php

namespace App\Http\Controllers\FeedBack;

use App\Events\UserFeedBack;
use App\Events\UserLiked;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$comment = Comment::create($validated);

		$user = User::find(auth('sanctum')->id());

		if ((int)$validated['author_id'] !== $user->id) {
			$notification = new Notification($validated);

			$user->notifications()->save($notification);

			$payload = (object)[
				'to'           => $notification->author_id,
				'from'         => auth('sanctum')->user()->username,
				'notification' => new NotificationResource($notification),
			];

			event(new UserFeedBack($payload));
		}

		event(new UserLiked(['comment' => new CommentResource($comment)]));

		return response()->json(['comment' => $comment], 201);
	}

	public function destroy(Comment $comment): JsonResponse
	{
		$comment->delete();

		return response()->json(['message' => __('validation.comment_deleted_successfully'), 200]);
	}
}
