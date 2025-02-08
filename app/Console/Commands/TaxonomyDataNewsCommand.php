<?php

namespace App\Console\Commands;

use App\Models\Blog\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TaxonomyDataNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:data-news-taxonomy {--taxonomy}';

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
        if($this->option('taxonomy'))
        {
            $taxonomy = $this->choice(
                'Update taxonomy type?',
                ['category', 'post_tag'],
                0
            );
            $db = DB::connection('simthaglog_news');
//            $wp_postmeta = $db->table('wp_options')
//                ->where('option_name', 'like','wpseo_taxonomy_meta')
//                ->where('option_value','!=','')
//                ->first();
//            $tags = unserialize($wp_postmeta->option_value);
//            dd(Arr::get($tags, 'post_tag'));
//            $collection = collect(array_values(Arr::get($tags, 'post_tag')));
//            $a = $collection->filter(function ($item) {
//                return isset($item['wpseo_title']);
//            });
//            dd($a->all());
            $posts = Post::has($taxonomy == 'category' ? 'categories' : 'tags', '=', 0)->get(['id']);
            foreach ($posts as $item) {
                $wp_postmeta = $db->select(
                    "select t.term_id from wp_terms t, wp_term_taxonomy tt, wp_term_relationships tr where t.term_id=tt.term_id AND tt.term_taxonomy_id=tr.term_taxonomy_id and tt.taxonomy='$taxonomy' and t.term_id != 429 and tr.object_id=$item->id"
                );
                if(count($wp_postmeta) > 0){
                    try {
                        $post = Post::find($item->id);
                        if($taxonomy == 'category'){
                            $post->categories()->attach($wp_postmeta[0]->term_id);
                        }else{
                            $post->tags()->attach(Arr::pluck($wp_postmeta, 'term_id'));
                        }
                        $post->saveQuietly();
                    }catch (\Exception $exception){
                        continue;
                    }
                }
            }
            $this->info("Updated total #{$posts->count()} News data added to queue!");
        }
    }
}
