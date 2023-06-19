<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Movie;
use App\Models\User;
use App\Policies\MoviePolicy;
use App\Policies\QuotePolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Movie::class => MoviePolicy::class,
        Quote::class => QuotePolicy::class
    ];

    public function boot()
    {
        Gate::define('update-movie', [MoviePolicy::class, 'update']);
        Gate::define('update-quote', [QuotePolicy::class, 'update']);
    }
}
