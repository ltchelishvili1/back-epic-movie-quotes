<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['director', 'title', 'description'];

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope('withGenres', function ($builder) {
            $builder->with('genres');
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

}
