<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Отримаємо сервіс через контейнер (після бінду інтерфейсу)
        $this->service = app(AuthorService::class);
    }

    public function test_author_search_by_name(): void
    {
        Author::factory()->create(['name' => 'Stephen King']);
        Author::factory()->create(['name' => 'Jane Austen']);

        $result = $this->service->search(['name' => 'King']);

        $this->assertCount(1, $result);
        $this->assertEquals('Stephen King', $result->first()->name);
    }

    public function test_empty_result_when_name_does_not_match(): void
    {
        Author::factory()->create(['name' => 'George Orwell']);

        $result = $this->service->search(['name' => 'Tolstoy']);

        $this->assertCount(0, $result);
    }

    public function test_all_authors_returned_when_no_filter_provided(): void
    {
        Author::factory()->count(3)->create();

        $result = $this->service->search([]);

        $this->assertCount(3, $result);
    }
}
