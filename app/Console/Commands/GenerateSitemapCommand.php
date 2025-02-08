<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {model} {--news}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate the sitemap.';

    /**
     * Execute the console command.
     * @throws \ReflectionException
     */
    public function handle()
    {
        $model = Str::ucfirst($this->argument('model'));
        if(in_array($model, ['Category','Tag','Post','Page'])) {
            $class = new ReflectionClass('App\\Models\\Blog\\'.$model);
            $file = Str::lower($model);
            if($this->option('news') && $model == 'Post') {
                $posts = $class->newInstance()
                    ->published()
                    ->whereDate('published_at', '>=', Carbon::now()->subDays(5))
                    ->get(['slug','published_at','title']);
                if($posts){
                    $data = [];
                    foreach ($posts as $post) {
                        $title = html_entity_decode($post->title, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
                        $data[] = Url::create(blog_route('blog.post', [$post->slug]))
                            ->setLastModificationDate(Carbon::create($post->published_at))
                            ->addNews(
                              'SimThangLong.vn',
                              'vi',
                              $title,
                              $post->published_at,
                            );
                    }
                    Sitemap::create()
                        ->add($data)
                        ->writeToFile(public_path("{$file}-news-sitemap.xml"));
                }
            }else{
                $posts = $class->newInstance()
                    ->published()
                    ->latest('published_at')
                    ->get(['slug','published_at','title','featured_image','content']);
                if($posts){
                    $data = [];
                    foreach ($posts as $post) {
                        $title = html_entity_decode($post->title, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
                        $url = Url::create(blog_route('blog.post', [$post->slug]))
                            ->setLastModificationDate(Carbon::create($post->published_at));
                        if($post->featured_image) {
                            $featured_image = Str::replace('storage/', '', $post->featured_image);
                            $featured_image = Str::ltrim($featured_image, '/');
                            $url->addImage(asset("storage/$featured_image"), $title,'', $title);
                        }
                        $images = extract_image_from_content($post->content);
                        if($images){
                            foreach ($images as $img) {
                                $url->addImage($img);
                            }
                        }
                        $data[] = $url;
                    }
                    Sitemap::create()
                        ->add($data)
                        ->writeToFile(public_path("{$file}-sitemap.xml"));
                }
            }
            $this->info('Sitemap generated successfully.');
        }else{
            $this->error('The model name does not exists: category, tag, post, page');
        }
    }
}
