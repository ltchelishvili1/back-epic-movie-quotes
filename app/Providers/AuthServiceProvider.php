<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Movie;
use App\Policies\CommentPolicy;
use App\Policies\LikePolicy;
use App\Policies\MoviePolicy;
use App\Policies\QuotePolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Movie::class => MoviePolicy::class,
        Quote::class => QuotePolicy::class,
        Comment::class => CommentPolicy::class,
        Like::class => LikePolicy::class,

    ];

    public function boot()
    {
        Gate::define('update-movie', [MoviePolicy::class, 'update']);
        Gate::define('update-quote', [QuotePolicy::class, 'update']);
        Gate::define('delete-like', [LikePolicy::class, 'delete']);
        Gate::define('delete-comment', [CommentPolicy::class, 'delete']);
    }
}
