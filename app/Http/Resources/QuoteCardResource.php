<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteCardResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'       => $this->id,
			'image'    => $this->image,
			'quote'    => $this->getTranslations('quote'),
			'movie_id' => $this->movie_id,
		];
	}
}
