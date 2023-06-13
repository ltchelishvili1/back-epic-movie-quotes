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

    protected $fillable = [
        'title',
        'director',
        'user_id',
        'release_year',
        'budget',
        'description',
        'image',
        'updated_at',
        'created_at'
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

}
