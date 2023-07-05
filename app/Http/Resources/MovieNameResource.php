<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieNameResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray($request)
	{
		return [
			'id'    => $this->id,
			'title' => $this->getTranslations('title'),
		];
	}
}
