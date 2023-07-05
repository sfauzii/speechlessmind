<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Tags\HasTags;

class Post extends \Stephenjude\FilamentBlog\Models\Post
{
    use HasFactory;

    public function scopeFilter($query, array $filters = []): void
    {
        $query->when($filters['search'] ?? false, fn ($query, $search) => $query
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('content', 'LIKE', "%$search%"));

        $query->when(
            $filters['category'] ?? false,
            fn ($query, $category) =>
            $query
                ->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                })
        );

        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas('author', function ($query) use ($author) {
                $query->where('name', 'LIKE', "%$author%");
            })
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
