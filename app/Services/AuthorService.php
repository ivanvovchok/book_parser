<?php

namespace App\Services;

use App\Repositories\Author\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorService
{
    public function __construct(protected AuthorRepositoryInterface $authorRepository) {}

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->authorRepository->search($filters);
    }
}
