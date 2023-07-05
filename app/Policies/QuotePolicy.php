<?php

namespace App\Policies;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuotePolicy
{
	public function update(User $user, Quote $quote)
	{
		return $user->id === $quote->user_id ? Response::allow()
		: Response::deny('Not Authorized.');
	}
}
