<?php

namespace App\Console\Commands;

use App\Models\Seo\PageSeo;
use Illuminate\Console\Command;

class UpdateLazyLoadSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data-seo {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update data seo lazy load';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seo_page = PageSeo::published()->paginate(500, ['id','content'], 'page', $this->argument('page'));
        foreach ($seo_page as $page) {
            if(!empty($page->content)) {
                $content = preg_replace("/<img (.*)>/", "<img loading=\"lazy\" decoding=\"async\" $1>", $page->content);
                $seo = PageSeo::find($page->id);
                $seo->content = $content;
                $seo->saveQuietly();
                $this->line("Replace data content seo #$page->id successfully !");
            }
        }
        $this->info("Done command update data seo lazy load");
    }
}
