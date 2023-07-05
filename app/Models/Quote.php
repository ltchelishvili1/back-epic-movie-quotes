<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
	use HasFactory;

	use HasTranslations;

	protected $guarded = ['id'];

	public $translatable = ['quote'];

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function likes(): BelongsToMany
	{
		return $this->belongsToMany(Like::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function notification(): HasMany
	{
		return $this->hasMany(Notification::class);
	}

	public function scopeSearch($query, $searchKey)
	{
		if (isset($searchKey)) {
			if (trim($searchKey)[0] === '#') {
				$search = ltrim($searchKey, $searchKey[0]);

				$query->where('quote->en', 'like', '%' . $search . '%')
					->orWhere('quote->ka', 'like', '%' . $search . '%');
			} else {
				$query->where(function ($query) use ($searchKey) {
					$query->where('quote->en', 'like', '%' . $searchKey . '%')
						->orWhere('quote->ka', 'like', '%' . $searchKey . '%');
				})->orWhereHas('movie', function ($query) use ($searchKey) {
					$query->where('title->en', 'like', '%' . $searchKey . '%')
						->orWhere('title->ka', 'like', '%' . $searchKey . '%');
				});
			}
		}

		return $query;
	}
}
