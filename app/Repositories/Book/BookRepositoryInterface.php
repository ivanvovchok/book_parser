<?php

namespace App\Repositories\Book;

use Illuminate\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator;
}


