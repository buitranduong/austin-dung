<?php

namespace App\Console\Commands;

use App\Jobs\UpdateDataNewsJob;
use App\Models\Blog\Post;
use Illuminate\Console\Command;

class UpdateDataNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data-news {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update data news from SimThangLong.vn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::published()
            ->oldest('published_at')
            ->paginate(500, ['id'], 'page', $this->argument('page'));
        foreach ($posts as $post) {
            dispatch(new UpdateDataNewsJob($post->id))->onQueue('default');
            $this->line("Data News #{$post->id} add to queue!");
        }
        $this->info("Updated total #{$posts->count()} News data added to queue!");
    }
}
