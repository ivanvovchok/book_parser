<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_authors_with_books_count()
    {
        $response = $this->getJson('/api/authors');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['name', 'books_count']
            ],
        ]);
    }

    public function test_it_returns_books_by_author()
    {
        $author = Author::factory()->create();
        $books = Book::factory()->count(2)->create();

        $author->books()->attach($books->pluck('id'));

        $response = $this->getJson("/api/authors/{$author->id}/books");

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                '*' => ['title', 'short_description', 'authors', 'published_date']
            ]
        ]);

        $response->assertJsonFragment([
            'title' => $books[0]->title,
        ]);
    }
}

