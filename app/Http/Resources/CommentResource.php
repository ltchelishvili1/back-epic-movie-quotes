<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'quote_id' => $this->quote_id,
			'id'       => $this->id,
			'user_id'  => $this->user_id,
			'comment'  => $this->comment,
			'user'     => User::find($this->user_id),
		];
	}
}
