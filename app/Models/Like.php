<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Like extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function quotes(): BelongsToMany
	{
		return $this->belongsToMany(Quote::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
