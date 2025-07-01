<?php

namespace App\Console\Commands;

use App\Enums\BookStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportBooks extends Command
{
    protected $signature = 'app:import-books';
    protected $description = 'Parse the books from the JSON file and import them into the database';

    public function handle(): void
    {
        $booksUrl = config('services.books.url');

        if (!$booksUrl) {
            $this->error('Books JSON URL is not configured.');
            return;
        }

        $response = Http::get($booksUrl);

        if ($response->failed()) {
            $this->error("Failed to fetch books from the URL: $booksUrl");
            return;
        }

        $books = $response->json();

        foreach ($books as $item) {
            if (!$this->isValidBookData($item)) {
                $this->warn('Skipping invalid item with missing ISBN, title or authors.');
                continue;
            }

            DB::transaction(fn() => $this->importBook($item));
        }

        $this->info('Books imported successfully.');
    }

    private function isValidBookData(array $item): bool
    {
        return isset($item['isbn'], $item['title'], $item['authors']) && is_array($item['authors']);
    }

    private function importBook(array $item): void
    {
        $book = Book::updateOrCreate(
            ['isbn' => $item['isbn']],
            [
                'title' => $item['title'],
                'short_description' => $item['shortDescription'] ?? null,
                'long_description' => $item['longDescription'] ?? null,
                'page_count' => $item['pageCount'] ?? null,
                'thumbnail_url' => $item['thumbnailUrl'] ?? null,
                'status' => $item['status'] ?? BookStatus::PUBLISH->value,
                'published_date' => $this->parseDate($item['publishedDate'] ?? null),
            ]
        );

        $this->syncAuthors($book, $item['authors'] ?? []);
        $this->syncCategories($book, $item['categories'] ?? []);
    }

    private function syncAuthors(Book $book, array $authors): void
    {
        $authorIds = collect($authors)
            ->filter(fn($name) => is_string($name) && trim($name) !== '')
            ->map(fn($name) => Author::firstOrCreate(['name' => trim($name)])->id);

        $book->authors()->sync($authorIds);
    }

    private function syncCategories(Book $book, array $categories): void
    {
        if (empty($categories)) {
            return;
        }

        $categoryIds = collect($categories)
            ->filter(fn($name) => is_string($name) && trim($name) !== '')
            ->map(fn($name) => Category::firstOrCreate(['name' => trim($name)])->id);

        $book->categories()->sync($categoryIds);
    }
    private function parseDate($publishedDate): ?string
    {
        if (!is_array($publishedDate) || !isset($publishedDate['$date'])) {
            return null;
        }

        try {
            return Carbon::parse($publishedDate['$date'])->format('Y-m-d');
        } catch (\Exception) {
            return null;
        }
    }
}
