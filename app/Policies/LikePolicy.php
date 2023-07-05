<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LikePolicy
{
	public function delete(User $user, Like $like)
	{
		return $user->id == $like->user_id ? Response::allow()
		: Response::deny('Not Authorized.');
	}
}
