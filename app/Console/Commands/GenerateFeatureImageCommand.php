<?php

namespace App\Console\Commands;

use App\Models\Blog\Post;
use Illuminate\Console\Command;

class GenerateFeatureImageCommand extends Command
{
    protected $signature = 'generate:feature-image';

    protected $description = 'Command generate the feature image for post.';

    public function handle(): void
    {
        $posts = Post::whereNotNull('featured_image')->get(['id', 'featured_image']);
        foreach ($posts as $post) {
            feature_image($post->featured_image, 293, 158);
            $this->line("Post #$post->id featured image generated.");
        }
        $this->info("Total {$posts->count()} Featured image generated.");
    }
}
