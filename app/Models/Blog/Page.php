<?php

namespace App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\PostType;

class Page extends Post
{
    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->type = PostType::Page;
            $post->created_by = auth()->id();
            $post->updated_by = auth()->id();
        });

        static::addGlobalScope('post-page', function (Builder $builder) {
            $builder->where('type', PostType::Page);
        });
    }
}