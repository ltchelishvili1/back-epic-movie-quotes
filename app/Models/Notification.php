<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $attributes = [
        'has_user_seen' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}