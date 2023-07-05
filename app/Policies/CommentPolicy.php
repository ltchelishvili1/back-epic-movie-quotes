<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
	public function delete(User $user, Comment $comment)
	{
		return $user->id == $comment->user_id ? Response::allow()
		: Response::deny('Not Authorized.');
	}
}
