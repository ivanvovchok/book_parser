<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookSearchRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {

    }

    public function index(BookSearchRequest $request): JsonResponse
    {
        $books = $this->bookService->search($request->validated());

        return BookResource::collection($books)
            ->response()
            ->setStatusCode(200);
    }
}
