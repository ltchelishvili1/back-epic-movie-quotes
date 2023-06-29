<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'has_user_seen' => $this->has_user_seen,
            'created_at' => $this->created_at,
            'id' => $this->id,
            'notification_sender' => User::find($this->user_id),
            'type' => $this->type

        ];
    }
}
