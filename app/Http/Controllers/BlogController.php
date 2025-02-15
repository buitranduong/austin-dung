<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Blog\Category;
use App\Models\Blog\Page;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use App\Models\User;
use App\Services\CacheModelService;
use App\Settings\BlogSetting;
use App\Supports\Amp\AMPDiv;
use App\Supports\Amp\AMPFigure;
use App\Supports\Amp\AMPHref;
use App\Supports\Amp\AMPImg;
use App\Supports\Amp\AMPMeta;
use App\Supports\Amp\AMPQuote;
use App\Supports\Amp\AMPTable;
use App\Supports\Schema\SchemaBlog;
use App\Utils\BlogMetaData;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use magyarandras\AMPConverter\Converter;
use Spatie\Feed\Feed;

class BlogController extends Controller
{
    public function __construct(protected MetaInterface $meta, protected BlogSetting $blogSetting)
    {
        $this->meta->includePackages(['news']);
        if($_GET){
            $this->meta->setRobots('noindex, noarchive');
        }
    }
    public function feature()
    {
        $posts = Post::with(['categories','updatedByUser:id,name'])
            ->published()
            ->latest('published_at')
            ->take(5)
            ->get();
        $feature_post = $posts->first();
        $ignore_id = $posts->pluck('id')->toArray();
        $phong_thuy_sim_posts = Category::with(['posts' => function ($query) use ($ignore_id) {
            $query->published()
                ->whereNotIn('posts.id', $ignore_id)
                ->latest('published_at')
                ->take(5);
        }])
            ->published()
            ->where('slug', 'tin-nguong')
            ->first();
        $sim_so_dep_posts = Category::with(['posts' => function ($query) use ($ignore_id) {
            $query->published()
                ->whereNotIn('posts.id', $ignore_id)
                ->latest('published_at')
                ->take(5);
        }])
            ->published()
            ->where('slug', 'cung-hoang-dao')
            ->first();
//        $tu_vi_posts = Category::with(['posts' => function ($query) {
//            $query->published()
//                ->latest('published_at')
//                ->take(12);
//        }])
//            ->published()
//            ->where('slug', 'tu-vi')
//            ->first();
        //shift feature post
        $posts->shift();
        $allCategories = CacheModelService::getBlogCategories(false);
        if ($allCategories) {
            foreach ($allCategories as $category) {
                $this->meta
                    ->addLink('alternate'.$category->id, ['rel'=>'alternate','href'=>blog_route('blog.category',[$category->slug]),'hreflang'=>'vi_VN'])
                    ->addLink('alternate-rss'.$category->id, [
                        'href'=>blog_route('blog.category',[$category->slug, 'view'=>'json']),
                        'rel'=>'alternate',
                        'type'=>'application/json',
                    ])
                    ->addLink('alternate-rss'.$category->id, [
                        'href'=>blog_route('blog.category',[$category->slug, 'view'=>'feed']),
                        'rel'=>'alternate',
                        'type'=>'application/rss+xml',
                        'title'=>$category->name,
                    ]);
            }
        }
        $this->meta->setKeywords('Austin Dũng')
            ->addLink('canonical', [
            'href'=>blog_route('blog.feature'),
        ]);
        $homepage = new Category();
        $homepage->featured_image = 'austindung.jpg';
        $this->_useSeoMetaTags(new BlogMetaData($homepage));
        return view('theme.blog.feature', compact('posts','feature_post','phong_thuy_sim_posts','sim_so_dep_posts'));
    }
    public function post(BlogSetting $blogSetting, SchemaBlog $schema, string $slug, ?string $view = null)
    {
        $post = Post::withoutGlobalScope('post-page')
            ->with(['categories:id,name,slug','tags:id,name,slug'])
            ->published()
            ->where('slug', $slug)
            ->first();
        if(!$post){
            abort(404);
        }
        $related_posts = [];
        if(!empty($post->category)){
            $ignore_id = [];
            if(!empty($post->next)){
                $ignore_id[] = $post->next->id;
            }
            if(!empty($post->previous)){
                $ignore_id[] = $post->previous->id;
            }
            $related_posts = $post->category
                ->posts($post->id)
                ->related($ignore_id)
                ->get();
        }
        switch ($view){
            case 'feed':
                if($post->type == PostType::Page){
                    abort(404);
                }
                return new Feed(
                    $post->category->name ?? '',
                    (new Collection([$post])),
                    !empty($post->category->slug) ? blog_route('blog.category',[$post->category->slug]) : '',
                    'feed::rss',
                    $post->category->description ?? '',
                    'vi-VN',
                    '',
                    'rss',
                    '',
                );
            case 'json':
                if($post->type == PostType::Page){
                    abort(404);
                }
                return new Feed(
                    $post->category->name ?? '',
                    (new Collection([$post])),
                    !empty($post->category->slug) ? blog_route('blog.category',[$post->category->slug]) : '',
                    'feed::json',
                    $post->category->description ?? '',
                    'vi_VN',
                    '',
                    'json',
                    '',
                );
            default:
                if($post->type == PostType::Post){
                    $this->meta
                        ->addLink('alternate', ['href'=>blog_route('blog.post',[$post->slug]),'hreflang'=>'vi_VN'])
                        ->addLink('alternate-rss', [
                            'href'=>blog_route('blog.post',[$post->slug, 'view'=>'json']),
                            'rel'=>'alternate',
                            'type'=>'application/json',
                        ])
                        ->addLink('alternate-rss', [
                            'href'=>blog_route('blog.post',[$post->slug, 'view'=>'feed']),
                            'rel'=>'alternate',
                            'type'=>'application/rss+xml',
                            'title'=>$post->title,
                        ])
                        ->addMeta('published_time',[
                            'property' => 'article:published_time',
                            'content' => $post->published_at->timezone($blogSetting->timezone)->toIso8601String(),
                        ])
                        ->addMeta('modified_time',[
                            'property' => 'article:modified_time',
                            'content' => $post->updated_at->timezone($blogSetting->timezone)->toIso8601String(),
                        ]);
                }
                $this->meta
                    ->addMeta('author', ['content'=>$post->createdByUser->name])
                    ->addLink('amphtml', [
                        'href'=>route('blog.post.amp',[$post->slug]),
                    ])
                    ->addLink('canonical', [
                        'href'=>blog_route('blog.post',[$post->slug]),
                    ]);
                break;
        }
        $schema->breadcrumbData($post)->registerTags();
        $schema->postData($post)->registerTags();
        $this->_useSeoMetaTags(new BlogMetaData($post));
        return view($this->getView("theme.blog.{$post->type->value}", $view), compact('post','related_posts'))->withShortcodes();
    }

    public function amp(string $slug, SchemaBlog $schema, BlogSetting $blogSetting)
    {
        $post = Post::withoutGlobalScope('post-page')
            ->with(['categories:id,name,slug','tags:id,name,slug'])
            ->published()
            ->where('slug', $slug)
            ->first();
        if(!$post){
            abort(404);
        }
        $related_posts = [];
        if(!empty($post->category)){
            $related_posts = $post->category->posts($post->id)->related()->get()->sortByDate();
        }
        $this->meta->reset();
        $this->meta
            ->setCharset()
            ->addMeta('viewport',['content'=>'width=device-width,minimum-scale=1'])
            ->addMeta('author', ['content'=>$post->createdByUser->name])
            ->addMeta('published_time',[
                'property' => 'article:published_time',
                'content' => $post->published_at->timezone($blogSetting->timezone)->toIso8601String(),
            ])
            ->addMeta('modified_time',[
                'property' => 'article:modified_time',
                'content' => $post->updated_at->timezone($blogSetting->timezone)->toIso8601String(),
            ])
            ->addLink('canonical', [
                'href'=>blog_route('blog.post',[$post->slug]),
            ]);
        $ampConverter = new Converter(url('').'/');
        $ampConverter->addConverter(new AMPQuote());
        $ampConverter->addConverter(new AMPTable());
        $ampConverter->addConverter(new AMPDiv());
        $ampConverter->addConverter(new AMPFigure());
        $ampConverter->addConverter(new AMPMeta());
        $ampConverter->addConverter(new AMPHref(url('').'/'));
        $ampConverter->addConverter(new AMPImg(url('').'/'));
        $ampConverter->loadDefaultConverters();
        $post->content = $ampConverter->convert($post->content);
        $schema->breadcrumbData($post)->registerTags();
        $schema->postData($post)->registerTags();
        $this->_useSeoMetaTags(new BlogMetaData($post));
        return view($this->getView("theme.blog.{$post->type->value}", 'amp'), compact('post','related_posts'));
    }
    public function category(Request $request, string $slug, ?string $view = null)
    {
        $category = Category::published()->where('slug', $slug)->first();
        if(!$category){
            abort(404);
        }
        $posts = $category->posts()
            ->where('status', PostStatus::Published)
            ->orderByDesc('published_at')
            ->paginate($this->blogSetting->post_limit);
        if($view){
            $view = $view == 'json' ? 'json' : 'rss';
            return new Feed(
                $category->name,
                $posts->getCollection(),
                blog_route('blog.category',[$category->slug]),
                "feed::{$view}",
                $category->description ?? '',
                'vi-VN',
                $category->featured_image ? feature_image($category->featured_image, 101, 70) : '',
                $view,
                '',
            );
        }
        $this->meta
            ->addLink('alternate', ['href'=>blog_route('blog.category',[$category->slug]),'hreflang'=>'vi_VN'])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.category',[$category->slug, 'view'=>'json']),
                'rel'=>'alternate',
                'type'=>'application/json',
            ])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.category',[$category->slug, 'view'=>'feed']),
                'rel'=>'alternate',
                'type'=>'application/rss+xml',
                'title'=>$category->name,
            ])
            ->setCanonical(blog_route('blog.category',[$category->slug]));
        if($request->has('page'))
        {
            $this->meta->setRobots('noindex, noarchive, follow');
        }
        $this->_useSeoMetaTags(new BlogMetaData($category));
        return view('theme.blog.category', compact('category','posts'));
    }
    public function tag(Request $request, string $slug, ?string $view = null){
        $tag = Tag::where('slug', $slug)->first();
        if(!$tag){
            abort(404);
        }
        $posts = $tag->posts()->orderByDesc('published_at')->paginate(10);
        if($view){
            $view = $view == 'json' ? 'json' : 'rss';
            return new Feed(
                $tag->name,
                $posts->getCollection(),
                blog_route('blog.tag',[$tag->slug]),
                "feed::{$view}",
                $tag->description ?? '',
                'vi-VN',
                $tag->featured_image ? feature_image($tag->featured_image, 101, 70) : '',
                $view,
                '',
            );
        }
        $this->meta
            ->addLink('alternate', ['href'=>blog_route('blog.tag',[$tag->slug]),'hreflang'=>'vi_VN'])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.tag',[$tag->slug, 'view'=>'json']),
                'rel'=>'alternate',
                'type'=>'application/json',
            ])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.tag',[$tag->slug, 'view'=>'feed']),
                'rel'=>'alternate',
                'type'=>'application/rss+xml',
                'title'=>$tag->name,
            ])
            ->setCanonical(blog_route('blog.tag',[$tag->slug]));
        if($request->has('page'))
        {
            $this->meta->setRobots('noindex, noarchive, follow');
        }
        $this->_useSeoMetaTags(new BlogMetaData($tag));
        return view('theme.blog.tag', compact('tag','posts'));
    }
    public function author(Request $request, string $slug, ?string $view = null)
    {
        $author = User::where('slug', $slug)->first();
        if(!$author){
            abort(404);
        }
        $posts = $author->posts()
            ->has('categories')
            ->where('status', PostStatus::Published)
            ->orderByDesc('published_at')
            ->paginate($this->blogSetting->post_limit);
        if($view){
            $view = $view == 'json' ? 'json' : 'rss';
            return new Feed(
                $author->name,
                $posts->getCollection(),
                blog_route('blog.author',[$author->slug]),
                "feed::{$view}",
                $author->description ?? '',
                'vi-VN',
                $author->avatar ? asset("storage/{$author->avatar}") : '',
                $view,
                '',
            );
        }
        $this->meta
            ->addLink('alternate', ['href'=>blog_route('blog.author',[$author->slug]),'hreflang'=>'vi_VN'])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.author',[$author->slug, 'view'=>'json']),
                'rel'=>'alternate',
                'type'=>'application/json',
            ])
            ->addLink('alternate-rss', [
                'href'=>blog_route('blog.author',[$author->slug, 'view'=>'feed']),
                'rel'=>'alternate',
                'type'=>'application/rss+xml',
                'title'=>$author->name,
            ])->addStyle('author.css',asset('static/theme/css/author.css'))
            ->setCanonical(blog_route('blog.author',[$author->slug]));
        if($request->has('page'))
        {
            $this->meta->setRobots('noindex, noarchive, follow');
        }
        $author->meta_data = [
            'title' => $author->name,
            'meta'=>[
                'description' => $author->description,
            ]
        ];
        $author->featured_image = $author->avatar;
        $this->_useSeoMetaTags(new BlogMetaData($author));
        return view('theme.blog.author', compact('author','posts'));
    }
    private function _useSeoMetaTags(BlogMetaData $seoMetaData): void
    {
        $this->meta->setTitle($seoMetaData->getMetaTitle());
        $this->meta->setDescription($seoMetaData->getMetaDescription());
        $this->meta->setKeywords($seoMetaData->getMetaKeywords());
        $tags = new TagsCollection($seoMetaData->getScriptPlacements());
        $this->meta->registerTags($tags);
        $og = new OpenGraphPackage('social');
        $og->setType('article');
        $og->setSiteName(config('app.name'));
        $og->setTitle(htmlspecialchars($seoMetaData->getMetaTitle()));
        $og->setDescription(Str::of(htmlspecialchars($seoMetaData->getMetaDescription()))->stripTags());
        if ($seoMetaData->getFeaturedImage()){
            $og->addImage(asset("storage/{$seoMetaData->getFeaturedImage()}"));
        }
        $og->setLocale('vi_VN');
        $og->setUrl(url()->current().'/');
        $this->meta->registerPackage($og);
        $card = new TwitterCardPackage('card');
        $card->setType('summary');
        $card->setTitle($seoMetaData->getMetaTitle());
        $card->setDescription($seoMetaData->getMetaDescription());
        if ($seoMetaData->getFeaturedImage()){
            $card->setImage(asset("storage/{$seoMetaData->getFeaturedImage()}"));
        }
        $this->meta->registerPackage($card);
    }

    public function page(Request $request)
    {
        $post = Page::where('slug', $request->path())
            ->published()
            ->first();
        if(!$post){
            abort(404);
        }
        $this->_useSeoMetaTags(new BlogMetaData($post));
        return view('theme.blog.page', compact('post'));
    }

    public function search(Request $request)
    {
        $posts = Post::search($request->get('q'), function ($query){
            $query->has('categories')
                ->published()
                ->orderByDesc('published_at');
        })->paginate($this->blogSetting->post_limit);

        $this->meta->setRobots('noindex, noarchive, follow');
        $seo = new Category();
        $seo->meta_data = [
            'title'=>'Kết quả tìm kiếm "'.$request->get('q').'"'
        ];
        $this->_useSeoMetaTags(new BlogMetaData($seo));
        return view('theme.blog.search', compact('posts'));
    }
}
