<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorSearchRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Services\AuthorService;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function __construct(protected AuthorService $authorService, protected BookService $bookService) {}

    public function index(AuthorSearchRequest $request): JsonResponse
    {
        $authors = $this->authorService->search($request->validated());

        return AuthorResource::collection($authors)
            ->response()
            ->setStatusCode(200);
    }

    public function books(int $authorId): JsonResponse
    {
        $books = $this->bookService->getByAuthor($authorId);

        return BookResource::collection($books)
            ->response()
            ->setStatusCode(200);
    }
}

