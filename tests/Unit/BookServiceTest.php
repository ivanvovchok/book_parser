<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(BookService::class);
    }

    public function test_search_by_title(): void
    {
        Book::factory()->create(['title' => 'Domain-Driven Design']);
        Book::factory()->create(['title' => 'Clean Code']);

        $results = $this->service->search(['title' => 'Clean']);

        $this->assertCount(1, $results);
        $this->assertEquals('Clean Code', $results->first()->title);
    }

    public function test_search_by_description(): void
    {
        Book::factory()->create(['short_description' => 'Best practices in software']);
        Book::factory()->create(['short_description' => 'Advanced design']);

        $results = $this->service->search(['description' => 'software']);

        $this->assertCount(1, $results);
        $this->assertStringContainsString('software', $results->first()->short_description);
    }

    public function test_get_by_author(): void
    {
        $author = Author::factory()->create();
        $books = Book::factory()->count(2)->create();

        $author->books()->attach($books);

        $results = $this->service->getByAuthor($author->id);

        $this->assertCount(2, $results);
        $this->assertEqualsCanonicalizing(
            $books->pluck('title')->toArray(),
            $results->pluck('title')->toArray()
        );
    }

    public function test_search_by_author_id(): void
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create();
        $book->authors()->attach($author);

        $results = $this->service->search(['author_id' => $author->id]);

        $this->assertCount(1, $results);
        $this->assertEquals($book->title, $results->first()->title);
    }
}
