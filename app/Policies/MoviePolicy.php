<?php

namespace App\Policies;

use App\Models\Movie;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class MoviePolicy
{
	public function update(User $user, Movie $movie)
	{
		return $user->id == $movie->user_id ? Response::allow()
		: Response::deny('Not Authorized.');
	}
}
