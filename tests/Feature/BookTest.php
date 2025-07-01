<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_returns_list_of_books()
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['title', 'short_description', 'authors', 'published_date']
            ],
        ]);
    }
}

