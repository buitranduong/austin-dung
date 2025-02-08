<?php

namespace App\Supports\Schema;

use App\Enums\PostType;
use App\Models\Blog\Post;
use App\Services\ScriptTagService;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagsCollection;
use Spatie\SchemaOrg\MultiTypedEntity;
use Spatie\SchemaOrg\Schema;

class SchemaBlog
{
    protected MultiTypedEntity $schema;
    public function __construct(protected MetaInterface $meta){}

    public function breadcrumbData(Post $post): static
    {
        $this->schema = new MultiTypedEntity();
        $itemList = [
            Schema::listItem()
                ->position(1)
                ->item(
                    Schema::thing()
                        ->addProperties(['@id'=>url('/')])
                        ->name('Kho SIM số đẹp từ【150k】cập nhật 2024 tại Sim Thăng Long')
                ),
            Schema::listItem()
                ->position(2)
                ->item(
                    Schema::thing()
                        ->addProperties(['@id'=>url('/')])
                        ->name('Sim Thăng Long - Tin Sim Số Đẹp, Phong Thủy, Tử vi mới nhất')
                ),
        ];
        if($post->type == PostType::Post && !empty($post->category)){
            $itemList[] = Schema::listItem()
                ->position(3)
                ->item(
                    Schema::thing()
                        ->addProperties(['@id'=>route('blog.category',[$post->category->slug])])
                        ->name($post->category->name ?? '')
                );
            $itemList[] = Schema::listItem()
                ->position(4)
                ->item(
                    Schema::thing()
                        ->addProperties(['@id'=>route('blog.post',[$post->slug])])
                        ->name($post->meta_data['title'] ?? $post->title)
                );
        }else{
            $itemList[] = Schema::listItem()
                ->position(3)
                ->item(
                    Schema::thing()
                        ->addProperties(['@id'=>route('blog.post',[$post->slug])])
                        ->name($post->meta_data['title'] ?? $post->title)
                );
        }
        $this->schema->breadcrumbList()
            ->itemListElement($itemList);
        return $this;
    }

    public function postData(Post $post): static
    {
        $this->schema = new MultiTypedEntity();
        $this->schema->newsArticle()
            ->mainEntityOfPage(
                Schema::webPage()->url(route('blog.post', [$post->slug]))
            )
            ->headline($post->meta_data['title'] ?? $post->title)
            ->description($post->meta_data['meta']['description'] ?? $post->excerpt)
            ->keywords($post->meta_data['meta']['keywords'] ?? '')
            ->datePublished($post->published_at)
            ->dateModified($post->updated_at)
            ->genre($post->category->name ?? '')
            ->wordCount(count(preg_split('/\s+/', $post->content)))
            ->author(
                Schema::person()
                    ->name($post->createdByUser->name)
                    ->url(route('blog.author',[$post->createdByUser->slug]))
            )
            ->publisher(
                Schema::organization()
                    ->name(config('app.name'))
                    ->addProperties(['@id'=>url('bai-viet/gioi-thieu').'/#organization'])
                    ->logo(
                        Schema::imageObject()->url(asset('/images/sim-so-dep-gia-re.png'))
                    )
            );
        $images = [];
        if(!empty($post->featured_image)){
            $images[] = Schema::imageObject()->url(asset($post->featured_image));
        }
        $arr_img = extract_image_from_content($post->content);
        if($arr_img){
            foreach ($arr_img as $img) {
                $images[] = Schema::imageObject()->url($img);
            }
        }
        if($images){
            $this->schema->newsArticle()->image($images);
        }
        return $this;
    }

    public function registerTags(): void
    {
        $head_script_after = $this->meta->placement('head_script_after')->toHtml();
        $schema_script = schema_format($this->schema->toArray());
        $script_tags = new ScriptTagService($head_script_after.$schema_script, 'head_script_after');
        $tags = new TagsCollection([$script_tags]);
        $this->meta->registerTags($tags);
    }
}
