<?php

namespace App\Console\Commands;

use App\Enums\CategoryType;
use App\Enums\PostStatus;
use App\Jobs\MigrateDataNewsJob;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateDataNewsCommand extends Command
{
    private static array $mapFields = [
        'ID'=>'id',
        'post_author'=>[
            'created_by',
            'updated_by',
        ],
        'post_date'=>[
            'created_at',
            'published_at',
        ],
        'post_modified'=>'updated_at',
        'post_content'=>'content',
        'post_title'=>'title',
        'post_excerpt'=>'excerpt',
        'post_name'=>'slug',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:data-news {page} {--taxonomy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command migrate data news from SimThangLong.vn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Post::query()->truncate();
        $db = DB::connection('simthaglog_news');
        //dd($db->select('SHOW TABLES'));
        if($this->option('taxonomy')){
            $taxonomy = $this->choice(
                'Migrate taxonomy type?',
                ['category', 'post_tag'],
                0
            );
            $wp_term_taxonomy = $db->table('wp_terms')
                ->join('wp_term_taxonomy', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
                ->where('wp_term_taxonomy.taxonomy', $taxonomy)
                ->get(['wp_terms.term_id','wp_terms.name','wp_terms.slug','wp_term_taxonomy.description']);
            foreach ($wp_term_taxonomy as $term)
            {
                try {
                    $category = new Category();
                    $category->fill((array)$term);
                    $category->id = $term->term_id;
                    $category->published = 1;
                    $category->type = ($taxonomy == 'category' ? CategoryType::Category : CategoryType::Tags);
                    $category->meta_data = [
                        'title'=>$term->name,
                        'meta'=>['description'=>$term->description],
                    ];
                    $category->created_by = 1;
                    $category->updated_by = 1;
                    $category->saveQuietly();
                }catch (\Exception $exception){
                    continue;
                }
                $this->line("Migrate data $taxonomy #$category->id successful !");
            }
            $this->info("Migrate total #{$wp_term_taxonomy->count()} taxonomy successful !");
        }else{
            $wp_posts = $db->table('wp_posts')
                ->where(['post_status'=>'publish', 'post_type'=>'post'])
                ->orderBy('post_date','ASC')
                ->paginate(200, [
                    'ID', 'post_author', 'post_date', 'post_content', 'post_title',
                    'post_excerpt', 'post_name', 'post_modified',
                ], 'page', $this->argument('page'));
            foreach ($wp_posts as $item) {
                $data = [];
                foreach (self::$mapFields as $field => $columns) {
                    if (isset($item->$field)){
                        if(is_array($columns)){
                            foreach ($columns as $column){
                                $data[$column] = $item->$field;
                            }
                        }else{
                            $data[$columns] = html_entity_decode($item->$field, ENT_QUOTES, 'UTF-8');
                            if($field == 'post_content'){
                                $data[$columns] = preg_replace("/<p[^>]*>(\s+)<\\/p[^>]*>/", '', wpautop($data[$columns]));
                            }
                        }
                    }
                }
                try {
                    $post = Post::findBySlug($data['slug']);
                    if($post){
                        $post->fill($data);
                    }else{
                        $post = new Post();
                        $post->fill($data);
                        $post->status = PostStatus::Published;
                        $post->meta_data = [
                            'title'=>$data['title']
                        ];
                    }
                    $post->saveQuietly();
                    dispatch(new MigrateDataNewsJob($post))->onQueue('default');
                    $this->line("Data News #{$item->ID} add to queue!");
                }catch (\Exception $exception){
                    continue;
                }
            }
            $this->info("Migrate total #{$wp_posts->count()} News data added to queue!");
        }
    }
}
