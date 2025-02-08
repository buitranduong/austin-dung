<?php

namespace App\Supports\Shortcode;

use App\Services\SimService;
use App\Settings\WarehouseSetting;
use App\Utils\DetectAgent;
use App\Utils\Helper;
use Illuminate\Support\Arr;

class ListSimTag
{
    public function __construct(
        protected SimService $simService,
        protected WarehouseSetting $warehouseSetting,
    )
    {}

    public function register($shortcode): string
    {
        $filter = Helper::getRequestParams(null, null, null, $this->warehouseSetting);
        if(isset($filter['all'])){
            $filter['all'] = array_merge($filter['all'], $this->getAttributes($shortcode->toArray()));
        }
        $sim_data = $this->fetchData($filter['all'] ?? $this->getAttributes($shortcode->toArray()));
        $mobile = Arr::get(DetectAgent::UseDevice(), 'touch');
        $keyword = '';
        return view('components.theme.shortcodes.list-sim', compact('sim_data','keyword', 'mobile'))->render();
    }

    protected function fetchData(array $filters)
    {
        return $this->simService->getSims(
            $filters,
            null,
            '',
            $this->warehouseSetting
        );
    }

    protected function getAttributes(array $attributes): array
    {
        return [
            'h'=>Arr::get($attributes, 'dauso'),
            'limit'=>Arr::get($attributes, 'limit'),
            'c'=>Arr::get($attributes, 'cat_ids'),
            't'=>Arr::get($attributes, 'telco_id'),
            'pr'=>implode('-', [Arr::get($attributes, 'min_price'), Arr::get($attributes, 'max_price')]),
            's'=>Arr::get($attributes, 's_id'),
            'page_db'=>5,
            'd'=>'random'
        ];
    }
}
