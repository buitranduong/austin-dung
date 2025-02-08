<?php

namespace App\Console\Commands;

use App\Models\Blog\Post;
use Illuminate\Console\Command;

class ReplaceDataNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:data-news';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $posts = Post::all(['id','content']);
        foreach ($posts as $item) {
            $post = Post::find($item->id);
            $post->content = str_replace(
                'https://prod.',
                'https://',
                $item->content
            );
            $post->content = preg_replace('/((<[^>]+) style=".*?)"(.*?)"(.*)/m', '$2>', $post->content);
            $post->saveQuietly();
            $this->line("Replaced #$item->id");
        }
        $this->info("Replace completed");
    }
}
