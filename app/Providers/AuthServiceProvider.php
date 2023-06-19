<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Movie;
use App\Policies\CrudPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Movie::class => CrudPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

    }
}
