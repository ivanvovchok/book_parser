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
            'title' => $this->resource->title,
            'short_description' => $this->resource->short_description,
            'long_description' => $this->resource->long_description,
            'authors' => $this->resource->authors->pluck('name'),
            'published_date' => $this->resource->published_date?->format('d.m.Y'),
        ];
    }
}
