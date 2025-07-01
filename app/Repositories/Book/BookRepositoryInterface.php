<?php

namespace App\Repositories\Book;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BookRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator;

    public function getByAuthor(int $authorId): Collection;
}
