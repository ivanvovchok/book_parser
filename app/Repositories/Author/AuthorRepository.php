<?php

namespace App\Repositories\Author;

use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator
    {
        return Author::query()
            ->withCount('books')
            ->when($filters['name'] ?? null, fn($q, $name) =>
                $q->where('name', 'like', '%' . $name . '%')
            )
            ->orderBy('name')
            ->paginate(15);
    }
}
