<?php

namespace App\Jobs;

use App\Models\Blog\Post;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class MigrateDataNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(protected Post $post) {}

    /**
     * Execute the job.
     */
    public function handle(ImageConvertService $imageConvertService): void
    {
        $db = DB::connection('simthaglog_news');
        $wp_postmeta = $db->table('wp_postmeta')
            ->whereIn('meta_key',['_yoast_wpseo_metadesc','_thumbnail_id','_yoast_wpseo_primary_category'])
            ->where('meta_value','!=','')
            ->where('post_id', $this->post->id)
            ->get(['meta_key','meta_value']);
        if($wp_postmeta->count() > 0){
            foreach ($wp_postmeta as $postmeta){
                switch ($postmeta->meta_key) {
                    case '_yoast_wpseo_metadesc':
                        $this->post->meta_data = array_merge(
                            $this->post->meta_data->toArray(),
                            ['meta'=>['description'=>$postmeta->meta_value]]
                        );
                        break;
                    case '_yoast_wpseo_primary_category':
                        try {
                            $this->post->categories()->sync($postmeta->meta_value);
                        }catch (\Exception $exception){
                            break;
                        }
                        break;
                    case '_thumbnail_id':
                        $attachment = $db->table('wp_posts')
                            ->where(['ID'=>$postmeta->meta_value, 'post_type'=>'attachment'])
                            ->first(['guid']);
                        if(!empty($attachment->guid)){
                            $ext = pathinfo($attachment->guid, PATHINFO_EXTENSION);
                            $name = Str::of(pathinfo($attachment->guid, PATHINFO_FILENAME))->slug();
                            $filename = "feature-$name.$ext";
                            $local = Str::remove('https://simthanglong.vn/bai-viet/wp-content/', $attachment->guid);
                            $localPath = str_replace(pathinfo($attachment->guid, PATHINFO_BASENAME), '', $local);
                            $fullPath = EnsureFolderUploadService::makeFolder(storage_path("app/public/$localPath"), false);
                            if(File::exists(storage_path("app/$local"))){
                                $content = File::get(storage_path("app/$local"));
                            }else{
                                $content = file_get_contents($attachment->guid);
                            }
                            $path = str_replace(storage_path('app').'/', '', $fullPath);
                            Storage::disk('local')->put(
                                "$path/$filename",
                                $content
                            );
                            $featured_image = $imageConvertService->fromPath("$fullPath/$filename")->convertAllSize($fullPath);
                            $this->post->featured_image = str_replace(storage_path('app/public').'/', '', $featured_image);
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        $terms = $db->table('wp_term_relationships')
            ->where(['object_id'=>$this->post->id])
            ->pluck('term_taxonomy_id');
        if(!empty($terms)){
            try {
                $this->post->tags()->sync($terms->toArray());
            }catch (\Exception $exception){

            }
        }

        if(!empty($this->post->content)){
            // clean wp tag
            $this->post->content = preg_replace("#<p><!--(.*?)--></p>#", "", $this->post->content);
            $this->post->content = str_replace(['<10','<ph'], ['10','ph'], $this->post->content);

            try{
                // replace image src
                $this->post->content = str_replace(
                    ['figure','figcaption'],
                    ['div','span'],
                    $this->post->content
                );
                $this->post->content = $this->cleanContent($this->post->content, $imageConvertService);
            }catch (\Exception $exception){
                Log::info("Migrate data news #{$this->post->id} exception");
                Log::error($exception->getMessage());
            }

            try{
                $this->post->content = preg_replace(
                    "#\[caption (.*?)](.*?)<img (.*?)>(.*?)\[/caption]#i",
                    "<div $1><img $3><span>$4</span></div>",
                    $this->post->content
                );
            }catch (\Exception $exception){
                Log::info("Migrate data news #{$this->post->id} exception");
                Log::error($exception->getMessage());
            }

            // replace a href
            $this->post->content = str_replace(
                'https://simthanglong.vn',
                '',
                $this->post->content
            );
        }
        $this->post->saveQuietly();
    }

    private function cleanContent(string $content, ImageConvertService $imageConvertService): string
    {
        $dom = new Dom();
        $dom->load($content);
        foreach ($dom->find('img') as $img) {
            $link = $img->getAttribute('src');
            $ext = pathinfo($link, PATHINFO_EXTENSION);
            if(!empty($ext)){
                $img->setAttribute('src', $this->saveImageToDisk($link, $ext, $imageConvertService));
            }
        }
        return (string)$dom;
    }

    private function saveImageToDisk(string $file, string $ext, ImageConvertService $imageConvertService): ?string
    {
        $local = Str::remove(
            [
                'https://simthanglong.vn/bai-viet/wp-content/',
                'http://demo.stl.vn/bai-viet/wp-content/',
                'http:/demo.stl.vn/bai-viet/wp-content/',
                'https://demo.stl.vn/bai-viet/wp-content/',
                'http://xsim.vn/wp-content/',
                'https://xsim.vn/wp-content/',
            ],
            $file);
        $local = Str::replace(
            [
                'http://simviphanoi.com/noidung/ckeditor/ckfinder/files/images/',
                'https://simviphanoi.com/noidung/ckeditor/ckfinder/files/images/',
                'https://static.simthanglong.vn/images/',
                'http://wordpress.local',
                'http:/wordpress.local',
                'https://wordpress.local',
            ],
            'uploads/',
            $local);
        if(File::exists(storage_path("app/$local"))){
            $content = File::get(storage_path("app/$local"));
        }else{
            $content = file_get_contents($file);
        }
        if($content){
            $name = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::of($name)->slug();
            $localPath = str_replace(pathinfo($file, PATHINFO_BASENAME), '', $local);
            $storage = storage_path("app/public/$localPath");
            $fullPath = EnsureFolderUploadService::makeFolder($storage);
            $path = str_replace(storage_path('app').'/', '', $fullPath);
            $saved = Storage::disk('local')->put("$path/$name.$ext", $content);
            if($saved && strtolower($ext) != 'gif'){
                $location = $imageConvertService->fromPath(storage_path("app/$path/$name.$ext"))->convertFitSize($storage);
                $location = str_replace('//', '/', $location);
                return str_replace(storage_path('app/public'), 'storage', $location);
            }
            $public = str_replace(storage_path('app/public'), 'storage', $fullPath);
            return "$public/$name.$ext";
        }
        return null;
    }
}
