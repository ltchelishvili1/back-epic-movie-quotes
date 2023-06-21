<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

        static::addGlobalScope('withQuotes', function ($builder) {
            $builder->with('quotes');
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

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function scopeSearch($query, $searchKey)
    {

        if (isset($searchKey) && trim($searchKey)[0] === '@') {
            $search = ltrim($searchKey, $searchKey[0]);
            $query->where('title->en', 'like', '%' . $search . '%')
                ->orWhere('title->ka', 'like', '%' . $search . '%');
        }



    }
}
