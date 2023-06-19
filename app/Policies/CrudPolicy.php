<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CrudPolicy
{
    public function view(User $user, $model): bool
    {

        if ($model instanceof Quote) {
            return $user->id === $model->user_id;
        }

        if ($model instanceof Movie) {
            return $user->id === $model->user_id;
        }

    }

}
