<?php

namespace App\Repositories\Author;

use Illuminate\Pagination\LengthAwarePaginator;

interface AuthorRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator;
}


