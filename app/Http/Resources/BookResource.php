<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'authors' => $this->authors->pluck('name'),
            'published_date' => $this->published_date?->format('d.m.Y'),
        ];
    }
}
