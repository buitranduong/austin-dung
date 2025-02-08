<?php

namespace App\Jobs;

use App\Models\Blog\Post;
use App\Services\EnsureFolderUploadService;
use App\Services\ImageConvertService;
use App\Supports\Laraberg\Blocks\ContentRenderer;
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

class UpdateDataNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(protected int $id){}

    /**
     * Execute the job.
     */
    public function handle(ContentRenderer $wp, ImageConvertService $imageConvertService): void
    {
        $db = DB::connection('simthaglog_news');
        $wp_posts = $db->table('wp_posts')
            ->where([
                'post_status'=>'publish',
                'post_type'=>'post',
                'ID'=>$this->id
            ])
            ->first(['post_content']);
        if ($wp_posts){
            $post = Post::find($this->id);
            if(!empty($wp_posts->post_content)){
                try{
                    // apply Laraberg parse
                    $post->content = $wp->render($wp_posts->post_content);
                    $post->content = preg_replace("/[\n\r]/", "", $post->content);
                    $post->content = $this->removeStyleAttributes($post->content);
                    $post->content = $this->removeStyleAttributes($post->content, 'dir');
                    $post->content = $this->removeStyleAttributes($post->content, 'id');
                    $post->content = str_replace(
                        ['figure','figcaption'],
                        ['div','span'],
                        $post->content
                    );
                    $post->content = preg_replace(
                        "#\[caption (.*?)](.*?)<img (.*?)>(.*?)\[/caption]#i",
                        "<figure $1><img $3><figcaption>$4</figcaption></figure>",
                        $post->content
                    );
                    // replace image src
                    $post->content = $this->cleanContent($post, $imageConvertService);
                    $post->saveQuietly();
                }catch (\Exception $exception){}
            }
        }
    }

    private function removeStyleAttributes($html, $attr='style') {
        // Regular expression to match style attributes with double quotes inside
        $pattern = '/'.$attr.'=(["\']).*?\1/';

        // Callback function to handle nested quotes
        $callback = function($matches) use ($attr) {
            // Ensure only the outer quotes are removed and the inner content is retained
            $attribute = $matches[0];
            $attribute = preg_replace('/^'.$attr.'=(["\'])/', '', $attribute);
            preg_replace('/(["\'])$/', '', $attribute);

            return '';
        };

        // Use preg_replace_callback to remove style attributes
        return preg_replace_callback($pattern, $callback, $html);
    }

    private function cleanContent($post, ImageConvertService $imageConvertService): string
    {
        $dom = new Dom();
        $dom->load($post->content);
        foreach ($dom->find('img') as $img) {
            $link = $img->getAttribute('src');
            $ext = pathinfo($link, PATHINFO_EXTENSION);
            if(!empty($ext)){
                $img->setAttribute('src', $this->saveImageToDisk($post, $link, $ext, $imageConvertService));
            }
        }
        return (string)$dom;
    }

    private function saveImageToDisk($post, string $file, string $ext, ImageConvertService $imageConvertService): ?string
    {
        $content = file_get_contents($file);
        if($content){
            // Đổi tên file thành slug
            $name = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::of($name)->slug();
            // Tạo folder theo ngày đăng
            $year = date('Y', strtotime($post->published_at));
            $month = date('m', strtotime($post->published_at));
            $fullPath = storage_path("app/public/uploads/$year/$month");
            File::ensureDirectoryExists($fullPath);
            // Save ảnh về storage
            $saved = Storage::disk('local')->put("public/uploads/$year/$month/$name.$ext", $content);
            if($saved){
                // Convert sang .webp nếu không phải là ảnh .gif
                if(strtolower($ext) != 'gif'){
                    $location = $imageConvertService->fromPath("$fullPath/$name.$ext")
                        ->convertFitSize($fullPath);
                    $location = str_replace('//', '/', $location);
                    return str_replace(storage_path('app/public'), 'storage', $location);
                }
                return "storage/uploads/$year/$month/$name.$ext";
            }
        }
        return $file;
    }
}
