<?php

namespace App\Supports\Schema;

use App\Services\CacheModelService;
use App\Services\ScriptTagService;
use App\Services\SimService;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagsCollection;
use DateTimeImmutable;
use Spatie\SchemaOrg\MultiTypedEntity;
use Spatie\SchemaOrg\Schema;

class SchemaProductDetail
{
    protected MultiTypedEntity $schema;
    protected array $simManufacture;

    public function __construct(protected MetaInterface $meta){}

    protected function getSimManufacture(array $simData): static
    {
        $manufacture = SimService::getSimManufacture($simData);
        foreach ($manufacture as $telco){
            if(isset($telco['@id'])){
                $this->simManufacture[] = Schema::organization()->name($telco['name'])->addProperties(['@id'=>$telco['@id']]);
            }else{
                $this->simManufacture[] = Schema::organization()->name($telco['name']);
            }
        }

        return $this;
    }

    protected function buildSchemaBasic(array $simData): MultiTypedEntity
    {
        $this->getSimManufacture($simData);
        $this->schema = new MultiTypedEntity();
        $this->schema->product()
            ->name($simData['title'])
            ->additionalType([
                'https://en.wikipedia.org/wiki/SIM_card',
                'http://www.productontology.org/doc/SIM_card',
                'https://vi.wikipedia.org/wiki/SIM_(%C4%91i%E1%BB%87n_tho%E1%BA%A1i)'
            ])
            ->addProperties(['@id'=>url($this->simData['detail']['id'] ?? '').'#product'])
            ->alternateName($simData['title'])
            ->description($simData['description'])
            ->url(url($simData['detail']['id']))
            ->image(url("{$simData['detail']['id']}.webp"))
            ->brand(
                Schema::organization()
                    ->name(config('app.name'))
                    ->addProperties(['@id'=>url('bai-viet/gioi-thieu').'/#organization'])
            )
            ->mpn($simData['detail']['id'])
            ->sku($simData['detail']['id'])
            ->productID($simData['detail']['id']);

        if(!empty($this->simManufacture)) {
            $this->schema->product()->manufacturer($this->simManufacture);
        }

        return $this->schema;
    }

    public function simSold(array $simData): static
    {
        $this->buildSchemaBasic($simData);
        $this->schema->product()
            ->offers(
                Schema::aggregateOffer()
                    ->availability(
                        Schema::itemAvailability()->url('https://schema.org/OutStock')
                    )
                    ->priceCurrency('VND')
                    ->itemCondition(
                        Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                    )
                    ->highPrice(0)
                    ->lowPrice(0)
                    ->price(0)
                    ->offerCount(1)
                    ->seller(
                        Schema::organization()
                            ->name(config('app.name'))
                            ->addProperties(['@id'=>url('bai-viet/gioi-thieu').'/#organization'])
                    )
                    ->shippingDetails(
                        Schema::offerShippingDetails()
                            ->shippingRate(
                                Schema::monetaryAmount()
                                    ->value(0)
                                    ->currency('VND')
                            )
                            ->shippingDestination(
                                Schema::definedRegion()
                                    ->addressCountry('VN')
                            )
                            ->deliveryTime(
                                Schema::shippingDeliveryTime()
                                    ->handlingTime(
                                        Schema::quantitativeValue()
                                            ->minValue(0)
                                            ->maxValue(1)
                                            ->unitCode('DAY')
                                    )
                                    ->transitTime(
                                        Schema::quantitativeValue()
                                            ->minValue(0)
                                            ->maxValue(3)
                                            ->unitCode('DAY')
                                    )
                                    ->cutoffTime(new DateTimeImmutable('21:00-07:00'))
                                    ->businessDays(
                                        Schema::openingHoursSpecification()
                                            ->dayOfWeek([
                                                Schema::dayOfWeek()->url('https://schema.org/Monday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Tuesday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Wednesday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Thursday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Friday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Saturday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Sunday'),
                                            ])
                                    )
                            )
                    )
            );
        return $this;
    }

    public function simData(array $simData): static
    {
        $simPageSeo = CacheModelService::getPageSeo("/{$simData['detail']['categoryUrl']}", []);
        $rangePrice = SimService::getSimTypePriceRange($simData['detail']['c2']);
        $this->buildSchemaBasic($simData);
        $this->schema->product()
            ->offers(
                Schema::aggregateOffer()
                    ->availability(
                        Schema::itemAvailability()->url('https://schema.org/InStock')
                    )
                    ->priceCurrency('VND')
                    ->itemCondition(
                        Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                    )
                    ->highPrice($simData['detail']['pn'])
                    ->lowPrice($simData['detail']['pn'])
                    ->price($simData['detail']['pn'])
                    ->offerCount(1)
                    ->seller(
                        Schema::organization()
                            ->name(config('app.name'))
                            ->addProperties(['@id'=>url('bai-viet/gioi-thieu').'/#organization'])
                    )
                    ->shippingDetails(
                        Schema::offerShippingDetails()
                            ->shippingRate(
                                Schema::monetaryAmount()
                                    ->value(0)
                                    ->currency('VND')
                            )
                            ->shippingDestination(
                                Schema::definedRegion()
                                    ->addressCountry('VN')
                            )
                            ->deliveryTime(
                                Schema::shippingDeliveryTime()
                                    ->handlingTime(
                                        Schema::quantitativeValue()
                                            ->minValue(0)
                                            ->maxValue(1)
                                            ->unitCode('DAY')
                                    )
                                    ->transitTime(
                                        Schema::quantitativeValue()
                                            ->minValue(0)
                                            ->maxValue(3)
                                            ->unitCode('DAY')
                                    )
                                    ->cutoffTime(new DateTimeImmutable('21:00-07:00'))
                                    ->businessDays(
                                        Schema::openingHoursSpecification()
                                            ->dayOfWeek([
                                                Schema::dayOfWeek()->url('https://schema.org/Monday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Tuesday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Wednesday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Thursday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Friday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Saturday'),
                                                Schema::dayOfWeek()->url('https://schema.org/Sunday'),
                                            ])
                                    )
                            )
                    )
            )
            ->category(
                Schema::product()
                    ->name($simPageSeo->title ?? '')
                    ->alternateName($simData->meta_data['title'] ?? '')
                    ->description($simData->meta_data['meta']['description'] ?? '')
                    ->productID(url($simPageSeo->slug ?? '/').'#product')
                    ->offers(
                        Schema::aggregateOffer()
                            ->availability(
                                Schema::itemAvailability()->url('https://schema.org/InStock')
                            )
                            ->priceCurrency('VND')
                            ->itemCondition(
                                Schema::offerItemCondition()->url('https://schema.org/NewCondition')
                            )
                            ->highPrice($rangePrice[1])
                            ->lowPrice($rangePrice[0])
                            ->offerCount(rand(19000, 300000))
                    )
                    ->url(url($simPageSeo->slug ?? '/'))
            )
            ->potentialAction(
                Schema::buyAction()
                    ->instrument([
                        Schema::thing()->name('phone'),
                        Schema::thing()->name('laptop'),
                        Schema::thing()->name('pc'),
                        Schema::thing()->name('tablet'),
                    ])
                    ->mainEntityOfPage(url('hoan-tat-dat-sim.html'))
                    ->name('Đặt hàng thành công')
                    ->url(url('hoan-tat-dat-sim.html'))
                    ->target(url('hoan-tat-dat-sim.html'))
                    ->description('Đặt hàng thành công - Sim Thăng Long')
                    ->priceSpecification(
                        Schema::priceSpecification()
                            ->valueAddedTaxIncluded(false)
                            ->priceCurrency('VND')
                            ->name("Giá mua ".($simData['title'] ?? ''))
                            ->price($simData['detail']['pn'])
                    )
            );
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

    public function toHtml(): string
    {
        return schema_format($this->schema->toArray());
    }
}
