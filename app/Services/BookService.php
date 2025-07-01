<?php

namespace App\Services;

use App\Repositories\Book\BookRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    protected BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->bookRepository->search($filters);
    }
}
