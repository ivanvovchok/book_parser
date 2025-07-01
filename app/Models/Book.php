<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'isbn',
        'page_count',
        'published_date',
        'thumbnail_url',
        'short_description',
        'long_description',
        'status',
    ];

    protected $casts = [
        'published_date' => 'date',
        'status' => BookStatus::class,
        'page_count' => 'integer',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'authors_books', 'book_id', 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'books_categories', 'book_id', 'category_id');
    }
}
