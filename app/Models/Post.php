<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin Eloquent
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 */

class Post extends Model
{
    use HasFactory;

    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn ($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
                ->orWhere('excerpt', 'like', '%' . $search . '%')
            )
        );

//        $query->when($filters['category'] ?? false, fn ($query, $category) =>
//            $query->whereExists(fn ($query) =>
//                $query->from('categories')
//                    ->where('categories.slug', $category)
//                    ->whereColumn('categories.id', 'posts.category_id') // used whereColumn() to compare the category.id column with the posts.category_id column
//            )
//        );

        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn($query) =>
                $query->where('slug', $category)
            )
        ); // This Makes The same query above, but in more simple lines of code.

        $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->whereHas('author', fn($query) => // used 'author' as the name of the Eloquent Relation.
                $query->where('username', $author)
            )
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo // $post->author
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): HasMany // $post->comments
    {
        return $this->hasMany(Comment::class);
    }

//    public function excerpt(): Attribute
//    {
//        return Attribute::make(
//          set: fn(string $value) => $this->attributes['excerpt'] = "<p>{$value}</p>"
//        );
//    }
//
//    public function body(): Attribute
//    {
//        return Attribute::make(
//          set: fn(string $value) => $this->attributes['body'] = "<p>{$value}</p>"
//        );
//    }
}
