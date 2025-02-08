<?php

namespace App\Supports\Schema;

use App\Enums\SimType;
use App\Models\Seo\PageSeo;
use App\Services\CacheModelService;
use App\Services\ScriptTagService;
use App\Services\SimService;
use App\Settings\WarehouseSetting;
use App\Utils\Helper;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagsCollection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\MultiTypedEntity;
use Spatie\SchemaOrg\Schema;

class SchemaProductCat
{
    protected MultiTypedEntity $schema;
    protected array $simManufacture;
    protected array $relatedTo = [];
    protected array $filter = [];
    protected int $highPrice = 1000000000;
    protected int $lowPrice = 350000;
    protected int $offerCount = 0;
    protected bool $isOK = true;

    public function __construct(
        protected MetaInterface $meta,
        protected WarehouseSetting $warehouseSetting,
        protected Request $request
    ){
        $this->offerCount = rand(150000, 300000);
    }

    public function telCo(array $filter): static
    {
        $this->filter = $filter;
        $simDetail = [];
        if(!empty($filter['origin']['telco'])){
            $simDetail = [
                'detail'=>[
                    'telcoText'=>$filter['origin']['telco']
                ]
            ];
        }else{
            if(isset($filter['origin']['h'])){
                if(Str::startsWith($filter['origin']['h'], '03')){
                    $simDetail = [
                        'detail'=>[
                            'telcoText'=>'viettel'
                        ]
                    ];
                }elseif(Str::startsWith($filter['origin']['h'], '07')){
                    $simDetail = [
                        'detail'=>[
                            'telcoText'=>'mobifone'
                        ]
                    ];
                }else{
                    $simTel = Helper::getSimTel($this->filter['origin']['h']);
                    if(isset($simTel['telco'])){
                        $simDetail = [
                            'detail'=>[
                                'telcoText'=>$simTel['telco']
                            ]
                        ];
                    }
                }
            }
            if(isset($filter['origin']['t'])){
                $simTel = collect(SimType::FILTER_TEL)->first(function($item){
                   return isset($item['t']) && $item['t'] == $this->filter['origin']['t'];
                });
                if(isset($simTel['telco'])){
                    $simDetail = [
                        'detail'=>[
                            'telcoText'=>$simTel['telco']
                        ]
                    ];
                }
            }
        }
        $manufacture = SimService::getSimManufacture($simDetail);
        foreach ($manufacture as $telco){
            if(isset($telco['@id'])){
                $this->simManufacture[] = Schema::organization()->name($telco['name'])->addProperties(['@id'=>$telco['@id']]);
            }else{
                $this->simManufacture[] = Schema::organization()->name($telco['name']);
            }
        }

        return $this;
    }

    protected function buildSchemaBasic(PageSeo $seoPage): MultiTypedEntity
    {
        $this->schema = new MultiTypedEntity();
        $this->schema->product()
            ->name($seoPage->title)
            ->additionalType([
                'https://en.wikipedia.org/wiki/SIM_card',
                'http://www.productontology.org/doc/SIM_card',
                'https://vi.wikipedia.org/wiki/SIM_(%C4%91i%E1%BB%87n_tho%E1%BA%A1i)'
            ])
            ->addProperties(['@id'=>$seoPage->slug ? url($seoPage->slug).'#product' : url()->current().'#product'])
            ->alternateName(!empty($seoPage->meta_data['title']) ? html_entity_decode($seoPage->meta_data['title']) : $seoPage->title)
            ->description(html_entity_decode($seoPage->meta_data['meta']['description'] ?? '') ?? '')
            ->url($seoPage->slug ? url($seoPage->slug) : url()->current())
            ->brand(
                Schema::organization()
                    ->name(config('app.name'))
                    ->addProperties(['@id'=>url('bai-viet/gioi-thieu').'/#organization'])
                    ->url(url('bai-viet/gioi-thieu'))
            )
            ->offers(
                Schema::aggregateOffer()
                    ->availability(
                        Schema::itemAvailability()->url('https://schema.org/InStock')
                    )
                    ->priceCurrency('VND')
                    ->itemCondition(
                        Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                    )
                    ->highPrice($seoPage->schema->maxPrice ?: $this->highPrice)
                    ->lowPrice($seoPage->schema->minPrice ?: $this->lowPrice)
                    ->offerCount($seoPage->schema->offerCount ?: $this->offerCount)
            )
            ->keywords(
                !empty($seoPage->meta_data['meta']['keywords'])
                    ? Str::of($seoPage->meta_data['meta']['keywords'])
                    ->trim()
                    ->explode(',')
                    ->toArray()
                    : ''
            );
        if(!empty($seoPage->featured_image)){
            $featured_image = Str::replace('storage/', '', $seoPage->featured_image);
            $featured_image = Str::ltrim($featured_image, '/');
            $this->schema->product()->image(asset('storage/'.$featured_image));
        }
        if(!empty($this->simManufacture)){
            $this->schema->product()->manufacturer($this->simManufacture);
        }

        return $this->schema;
    }

    protected function detectHeadTel(): string
    {
        // doi voi dau so xac dinh duoc nha mang
        $catSlug = '';
        if(isset($this->filter['origin']['h'])){
            if(Str::length($this->filter['origin']['h']) > 2){
                $telco = Helper::getSimTel($this->filter['origin']['h']);
                if(isset($telco['link'])){
                    $catSlug = Str::ltrim($telco['link'], '/');
                }
            }elseif (Str::length($this->filter['origin']['h']) == 2) {
                if($this->filter['origin']['h'] == '03'){
                    $catSlug = 'sim-viettel';
                }elseif ($this->filter['origin']['h'] == '07'){
                    $catSlug = 'sim-mobifone';
                }
            }
        }
        return $catSlug;
    }

    protected function getCategorySeo(PageSeo $seoPage): void
    {
        $title = '';
        if(!empty($seoPage->schema_product)){
            $catSlug = $seoPage->schema_product;
            if(Str::isUrl($catSlug)){
                $catSlug = parse_url($catSlug, PHP_URL_PATH);
            }
            $catSlug = Str::ltrim($catSlug, '/');
        }else{
            $catSlug = $this->detectHeadTel();
            // kiem tra cau truc duoi so
            if(isset($this->filter['origin']['tail'])){
                $simType = Helper::detectSimType($this->filter['origin']['tail']);
                if($simType){
                    $title = $simType;
                    $catSlug = Str::of($simType)->trim()->prepend('sim-')->slug();
                }
                // neu co dau so ket hop
                if(isset($this->filter['origin']['h'])){
                    $headTel = $this->detectHeadTel();
                    if($headTel){
                        $headTel = Str::replace(['sim-','so-dep-'], '', $headTel);
                        $title .= ' '.$headTel;
                        $catSlug = Str::of($catSlug)
                            ->replace("-{$headTel}",'')
                            ->append("-{$headTel}")
                            ->trim()
                            ->slug();
                    }
                }
            }
            if(
                isset($this->filter['origin']['t']) &&
                isset($this->filter['origin']['link']) &&
                !isset($this->filter['origin']['telco'])
            ){
                // co t nhung ko xac dinh nha mang telco
                $catSlug = Str::ltrim($this->filter['origin']['link'], '/');
            }
        }
        $category = CacheModelService::setPageSeo("/$catSlug");
        if($category){
            $filter = Helper::getRequestParams("/$catSlug", $category, $this->request, $this->warehouseSetting);
            if(isset($filter['origin']['priceRange'])){
                $lowPrice = $filter['origin']['priceRange'][0];
                $highPrice = $filter['origin']['priceRange'][1];
            }
            $this->schema->product()->category(
                Schema::product()
                    ->name($category->title ?? '')
                    ->alternateName($category->meta_data['title'] ?? '')
                    ->description($category->meta_data['meta']['description'] ?? '')
                    ->addProperties(['@id'=> url("$category->slug#product")])
                    ->offers(
                        Schema::aggregateOffer()
                            ->availability(
                                Schema::itemAvailability()->url('https://schema.org/InStock')
                            )
                            ->priceCurrency('VND')
                            ->itemCondition(
                                Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                            )
                            ->highPrice(!empty($highPrice) ? $highPrice : $this->highPrice)
                            ->lowPrice(!empty($lowPrice) ? $lowPrice : $this->lowPrice)
                            ->offerCount($this->offerCount)
                    )
                    ->url(url($category->slug))
            );
        }else{
            $this->schema->product()->category(
                Schema::product()
                    ->name(Str::headline("Sim $title"))
                    ->addProperties(['@id'=> url("$catSlug#product")])
                    ->offers(
                        Schema::aggregateOffer()
                            ->availability(
                                Schema::itemAvailability()->url('https://schema.org/InStock')
                            )
                            ->priceCurrency('VND')
                            ->itemCondition(
                                Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                            )
                            ->highPrice(!empty($highPrice) ? $highPrice : $this->highPrice)
                            ->lowPrice(!empty($lowPrice) ? $lowPrice : $this->lowPrice)
                            ->offerCount($this->offerCount)
                    )
                    ->url(url($catSlug))
            );
        }
    }

    protected function getRelatedSeo(PageSeo $seoPage): void
    {
        if(!empty($seoPage->related_content)){
            $link = collect($seoPage->related_content)->map(function($item){
                if(Str::isUrl($item['link'])){
                    $item['link'] = parse_url($item['link'], PHP_URL_PATH);
                }
                $item['link'] = '/'.Str::ltrim($item['link'], '/');
                return $item;
            })->pluck('link')->all();
            if(is_array($link) && count($link) > 0){
                $seoPages = PageSeo::published()->whereIn('slug', $link)->get(['slug','title','meta_data']);
                if ($seoPages){
                    foreach ($seoPages as $page){
                        if (($key = array_search($page->slug, $link)) !== false) {
                            unset($link[$key]);
                        }
                        $this->relatedTo[] = Schema::product()
                            ->name($page->title)
                            ->alternateName($page->meta_data['title'] ?? '')
                            ->description($page->meta_data['meta']['description'] ?? '')
                            ->url(url($page->slug))
                            ->addProperties(['@id'=>url($page->slug).'/#product']);
                    }
                }
                if(count($link) > 0){
                    foreach ($link as $slug){
                        // ignore error
                        try {
                            $filter = Helper::getRequestParams($slug, null, $this->request, $this->warehouseSetting);
                            $this->relatedTo[] = Schema::product()
                                ->name($filter['origin']['title'] ?? '')
                                ->alternateName($filter['origin']['meta_data']['title'] ?? '')
                                ->description($filter['origin']['meta_data']['meta']['description'] ?? '')
                                ->url(url($slug))
                                ->addProperties(['@id'=>url($slug).'/#product']);
                        }catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }
            unset($link);
        }else{
            // /tim-sim/xx*xx
            if(
                isset($this->filter['origin']['h']) &&
                Str::length($this->filter['origin']['h']) == 2 &&
                isset($this->filter['origin']['tail'])
            ){
                collect(SimType::FILTER_TEL)->map(function ($item){
                    if (isset($item['heads']) && count($item['heads']) > 0) {
                        foreach ($item['heads'] as $head) {
                            if(Str::startsWith($head, $this->filter['origin']['h'])){
                                $link = "/tim-sim/$head*{$this->filter['origin']['tail']}.html";
                                $filter = Helper::getRequestParams($link, null, $this->request, $this->warehouseSetting);
                                $this->relatedTo[] = Schema::product()
                                    ->name($filter['origin']['title'] ?? '')
                                    ->alternateName($filter['origin']['meta_data']['title'] ?? '')
                                    ->description($filter['origin']['meta_data']['meta']['description'] ?? '')
                                    ->url(url($link))
                                    ->addProperties(['@id'=>url($link).'/#product']);
                            }
                        }
                    }
                });
            }
            if(
                isset($this->filter['origin']['h']) &&
                Str::length($this->filter['origin']['h']) > 2 &&
                Str::length($this->filter['origin']['h']) < 4
            ){
                for ($i=2; $i<10; $i++){
                    if(isset($this->filter['origin']['tail'])){
                        $link = "/tim-sim/{$this->filter['origin']['h']}$i*{$this->filter['origin']['tail']}.html";
                    }else{
                        $link = "/tim-sim/sim-dau-so-{$this->filter['origin']['h']}$i.html";
                    }
                    $filter = Helper::getRequestParams($link, null, $this->request, $this->warehouseSetting);
                    $this->relatedTo[] = Schema::product()
                        ->name($filter['origin']['title'] ?? '')
                        ->alternateName($filter['origin']['meta_data']['title'] ?? '')
                        ->description($filter['origin']['meta_data']['meta']['description'] ?? '')
                        ->url(url($link))
                        ->addProperties(['@id'=>url($link).'/#product']);
                }
            }

        }
    }

    public function pageSeo(PageSeo $seoPage): static
    {
        $this->buildSchemaBasic($seoPage);
        $this->getCategorySeo($seoPage);
        $this->getRelatedSeo($seoPage);
        return $this;
    }

    public function simData(LengthAwarePaginator $simData): static
    {
        $topTen = $simData->slice(0, 10);
        if($topTen->count() > 0){
            $topTen->map(function ($item) {
                $sim = str_split($item['id']);
                $sim = Arr::prependKeysWith($sim, 'f');
                $sim = ['detail'=>array_merge($item, $sim)];
                CacheModelService::getSimSeo($sim);
                $this->relatedTo[] = Schema::product()
                    ->name($sim['title'] ?? '')
                    ->alternateName($sim['h1'] ?? '')
                    ->description($sim['description'] ?? '')
                    ->url(url($item['id']))
                    ->addProperties(['@id'=>url($item['id']).'/#product']);
            });
        }else{
            $this->isOK = false;
        }
        $this->setRelatedTo();
        return $this;
    }

    protected function setRelatedTo(): void
    {
        if(count($this->relatedTo)){
            $this->schema->product()->isRelatedTo($this->relatedTo);
        }
    }

    public function registerTags(): void
    {
        if($this->isOK){
            $head_script_after = $this->meta->placement('head_script_after')->toHtml();
            $schema_script = schema_format($this->schema->toArray());
            $script_tags = new ScriptTagService($head_script_after.$schema_script, 'head_script_after');
            $tags = new TagsCollection([$script_tags]);
            $this->meta->registerTags($tags);
        }
    }

    public function toHtml(): string
    {
        if($this->isOK){
            return schema_format($this->schema->toArray());
        }
        return '';
    }
}
