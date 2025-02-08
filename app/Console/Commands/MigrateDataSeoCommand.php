<?php

namespace App\Console\Commands;

use App\Jobs\MigrateDataSeoJob;
use App\Models\Seo\PageSeo;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateDataSeoCommand extends Command
{
    private static array $mapFields = [
        'title'=>'title',
        'h1'=>'title',
        'link'=>'slug',
        'thumbnail'=>'featured_image',
        'description'=>'excerpt',
        'detail'=>'content',
        'heades'=>'head_script_after',
        'similar'=>'related_content',
        'updated_at'=>'published_at',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:data-seo';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $data = DB::connection('simthaglog_db')
            ->table('tbl_seoinfo')
            ->where('status', 1)
            ->get();
        if($data){
            foreach($data as $row){
                $seo_page = new PageSeo();
                $meta_data = [];
                foreach ($this::$mapFields as $field => $key) {
                    switch ($field) {
                        case 'title':
                            $meta_data[$key] = html_entity_decode($row->$field);
                            break;
                        case 'description':
                            $meta_data['meta'][$field] = html_entity_decode($row->$field, ENT_QUOTES, 'UTF-8');
                            $seo_page->$key = $row->$field;
                            break;
                        case 'h1':
                            $seo_page->title = $row->$field;
                            $seo_page->h2 = "{$row->$field} - Bí quyết chọn sim";
                            break;
                        case 'link':
                            $slug = Str::replace('https://simthanglong.vn', '', $row->$field);
                            if (empty($slug)) {
                                $slug = '/';
                            }else{
                                if(!Str::startsWith($slug, '/tim-sim')){
                                    $path = Str::of($slug)->explode('/');
                                    if($path->count() > 2){
                                        $slug = Str::replace(['tu','.html'], ['sim',''], $path->last());
                                    }
                                }
                            }
                            $seo_page->$key = $slug;
                            break;
                        case 'similar':
                            $related = preg_split('/\r\n|[\r\n]/', $row->$field);
                            if (is_array($related)) {
                                foreach ($related as $i=>$item) {
                                    $related[$i] = Str::replace('https://simthanglong.vn/', '', $item);
                                }
                            }
                            $seo_page->$key = $related;
                            break;
                        case 'updated_at':
                            try {
                                Carbon::parse($row->$field);
                            } catch (\Exception $e) {
                                $seo_page->$key = now();
                            }
                            break;
                        default:
                            $seo_page->$key = $row->$field;
                            break;
                    }
                }
                $seo_page->meta_data = $meta_data;
                dispatch(new MigrateDataSeoJob($seo_page->toArray()))->onQueue('default');
                $this->line("Data Seo #{$row->id} add to queue!");
            }
        }
        $this->info("Migrate total #{$data->count()} Seo data added to queue!");
    }
}
