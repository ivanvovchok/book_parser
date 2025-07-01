<?php

namespace App\Services;

use App\Repositories\Book\BookRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookService
{
    public function __construct(protected BookRepositoryInterface $bookRepository) {}

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->bookRepository->search($filters);
    }

    public function getByAuthor(int $authorId): Collection
    {
        return $this->bookRepository->getByAuthor($authorId);
    }
}
