<?php

namespace App\Repositories\Book;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator
    {
        return Book::query()->with('authors')
            ->when($filters['title'] ?? null, fn($q, $title) =>
            $q->where('title', 'like', "%{$title}%")
            )
            ->when($filters['description'] ?? null, fn($q, $description) =>
            $q->where('short_description', 'like', "%{$description}%")->orWhere('long_description', 'like', "%{$description}%")
            )
            ->when($filters['author_id'] ?? null, fn($q, $authorId) =>
            $q->whereHas('authors', fn($q) => $q->where('id', $authorId))
            )
            ->paginate(15);
    }
}
