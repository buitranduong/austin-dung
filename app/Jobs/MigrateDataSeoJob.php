<?php

namespace App\Jobs;

use App\Models\Seo\PageSeo;
use App\Services\ImageConvertService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateDataSeoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data){}

    /**
     * Execute the job.
     */
    public function handle(ImageConvertService $imageConvertService): void
    {
        if (!empty($this->data)){
            $seo_page = new PageSeo();
            $seo_page->fill($this->data);
            if(!empty($seo_page->related_content)){
                $seo_page->related_content = $this->cleanRelatedContent($seo_page->related_content);
            }
            if(!empty($seo_page->content)){
                $seo_page->content = $this->cleanContent($seo_page->content, $imageConvertService);
                $seo_page->content = Str::replace('https://simthanglong.vn', url(''), $seo_page->content);
            }
            if(!empty($seo_page->featured_image)) {
                $seo_page->featured_image = $this->saveImageToDisk(
                    $seo_page->featured_image,
                    pathinfo($seo_page->featured_image, PATHINFO_EXTENSION),
                    $imageConvertService
                );
            }
            $seo_page->created_by = 1;
            $seo_page->updated_by = 1;
            $seo_page->saveQuietly();
        }
    }

    private function cleanRelatedContent(string|array $content): array
    {
        if(is_array($content)){
            foreach ($content as $i=>$item) {
                $content[$i] = preg_replace('#<a (.*) href="(.*)">(.*)</a>#', '$3|$2', $item);
            }
        }else{
            $content = [preg_replace('#<a (.*) href="(.*)">(.*)</a>#', '$3', $content)];
        }
        return $content;
    }

    private function cleanContent(string $content, ImageConvertService $imageConvertService): string
    {
        $doc = new \DOMDocument();
        $doc->loadHTML(mb_encode_numericentity($content, [0x80, 0x10FFFF, 0, ~0], 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $tags = $doc->getElementsByTagName('img');
        if($tags->length > 0)
        {
            for ($i = 0; $i < $tags->length; $i++) {
                $tag = $tags->item($i);
                $link = $tag->getAttribute('src');
                $ext = pathinfo($link, PATHINFO_EXTENSION);
                if(!empty($ext)){
                    $tag->setAttribute('src', $this->saveImageToDisk($link, $ext, $imageConvertService));
                }
            }
        }
        return $doc->saveHTML();
    }

    private function saveImageToDisk(string $file, string $ext, ImageConvertService $imageConvertService): ?string
    {
        $local = Str::remove('https://static.simthanglong.vn/', $file);
        if(File::exists(storage_path("app/$local"))){
            $content = File::get(storage_path("app/$local"));
        }else{
            $content = file_get_contents($file);
        }
        if($content){
            $name = pathinfo($file, PATHINFO_FILENAME);
            $name = Str::of($name)->slug();
            $path = 'public/images';
            $saved = Storage::put("$path/$name.$ext", $content);
            if($saved && strtolower($ext) != 'gif'){
                $storage = storage_path("app/$path");
                $location = $imageConvertService->fromPath("$storage/$name.$ext")->convertFitSize($storage);
                Storage::delete("$path/$name.$ext");
                return str_replace(storage_path('app/public'), url('storage'), $location);
            }
            return url("storage/images/$name.$ext");
        }
        return null;
    }
}
