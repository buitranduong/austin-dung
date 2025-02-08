<?php

namespace App\Services;
use App\Enums\SchemaConstant;
use App\Enums\SimType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Utils\Helper;
use Illuminate\Support\Collection;
use App\Settings\WarehouseSetting;
use App\Settings\GeneralSetting;
use App\Services\SimInstallmentService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SimService
{
    protected $simInstallmentService;
    protected $generalSetting;

    public function __construct(SimInstallmentService $simInstallmentService, GeneralSetting $generalSetting)
    {
        $this->simInstallmentService = $simInstallmentService;
        $this->generalSetting = $generalSetting;
    }

    public function getSims($params, $request, $api_path=null, WarehouseSetting $warehouseSetting) {
        $api_sim_url = config('constant.api_sim_url');
        // convert params url object to params sim query object
        $simQueryObj = Helper::convertURLParamsToAPIParams($params);
        // set limit query sim from general setting
        if (!array_key_exists('limit', $simQueryObj)) {
            $simQueryObj['limit'] = $this->generalSetting->sim_limit;
        }
        // convert params object to query string url params
        $queryString = http_build_query($simQueryObj);
        if(!$api_path) {
            $api_path = "search4/query4/";
        }
        $api_sim_url = "$api_sim_url/$api_path?$queryString";
        //dd($api_sim_url);
        try {
            //$start = microtime(true);
            $response = Http::get($api_sim_url);
            //$end = microtime(true);
            //$timeInMillis = ($end - $start) * 1000;
            //Log::error("TIME CALL SIMVN-----git-->>>>>>>>>>{$api_sim_url} #{$timeInMillis}");

            if ($response->successful()) {
                $responseData = $response->json();
                // neu query tu trang homepage
                if (array_key_exists('from_home', $params) && $params['from_home']) {
                    if(isset($responseData['data'])) {
                        return $responseData['data'];
                    } else {
                        Helper::sendTelegramMsg("[". config('app.env'). "] WARNING HOMEPAGE NULL>> $api_sim_url");
                        return [];
                    }
                } else {
                    // if (count($responseData['data'] ?? [])==0){
                    //     Helper::sendTelegramMsg(config('app.env'). " WARNING ZERO DATA>> $api_sim_url");
                    // }
                    $data = $this->applyAllConditions(
                        $responseData['data'] ?? [],
                            $params['priority_sims'] ?? null,
                        $warehouseSetting,
                            $request,
                            $simQueryObj
                    );
                    // apply phan trang
                    return (new Collection($data))->paginate(
                        $responseData['meta']['limit'] ?? 1,
                        $responseData['meta']['total'] ?? 0,
                        $responseData['meta']['page'] ?? 1
                    )->withQueryString();
                }
            } else {
                return $response->status();
            }
        } catch (\Illuminate\Http\Client\RequestException |
            \Illuminate\Http\Client\ConnectionException $exception) {
            $statusCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            Helper::sendTelegramMsg("[".config('app.env'). "] getSims>> $statusCode >>> $errorMessage");
            return (new Collection([]))->paginate(1,0,1)->withQueryString();
        }
    }
    // get sims block data for homepage
    public function getHomePageSimBlock($params, $request, WarehouseSetting $warehouseSetting) {
        //$start = microtime(true);
        $params['from_home'] = true;
            $home_sim_block =  $this->getSims($params, $request, "search4/stl-hompage4", $warehouseSetting);
            if(!empty($home_sim_block['block'])){
                foreach($home_sim_block['block'] as $block=>$data){
                    $home_sim_block['block'][$block]['listSim'] = $this->applyAllConditions($data['listSim'], null, $warehouseSetting, $request);
                }
        }
        //$end = microtime(true);
        //$timeInMillis = ($end - $start) * 1000;
        //Log::error("TIME CALL HOMEPAGE------->>>>>>>>>> #{$timeInMillis}");
        return $home_sim_block;
    }

    public function getSimDetail($sim, WarehouseSetting $setting) {
        $api_sim_url = config('constant.api_sim_url');
        $sim_update_lt_days=$setting->sim_update_lt_days;
        $not_store = str_replace(' ','', implode(',', $setting->ignores_warehouse));
        $api_sim_url = "$api_sim_url/detail/index-no-seo?sim=$sim&l_sec=$sim_update_lt_days&notStore=$not_store";
        try {
            $response = Http::timeout(10)->get($api_sim_url);
            if ($response->successful()) {
                $data = $response->json();
                $sim = $data['data']['simInfo'] ?? [];
                if (count($sim)>0) {
                    $sim_data = $this->applyAllConditions([$sim['detail']], null, $setting);
                    $sim['detail'] = $sim_data[0];
                    return $this->getAllInstallmentExists($sim);
                }
            } else {
                return $response->status();
            }
        } catch (\Illuminate\Http\Client\RequestException |
            \Illuminate\Http\Client\ConnectionException $exception) {
            $statusCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            Helper::sendTelegramMsg("[".config('app.env'). "] getSimDetail>> $statusCode >>> $errorMessage");
            return null;
        }
        return [];
    }

    public static function getSimTypes(): Collection
    {
        $sim_types = collect(SimType::FILTER_CATES)->filter(function ($item) {
           return !empty($item['c']);
        });
        $sim_types->transform(function ($item) {
            return [
                'id' => $item['c'],
                'name' => $item['title'],
            ];
        });
        return $sim_types;
    }

    public static function getSimTypePriceRange(int $c2): array
    {
        $range_price = collect(SimType::FILTER_CATES)->filter(function ($item) use($c2) {
            return !empty($item['c']) and $item['c'] == $c2;
        });
        if($range_price->count() == 0) {
            return [rand(250000,50000000), rand(100000000,1000000000)];
        }
        $range_price->transform(function ($item) {
            return $item['priceRange'] ?? [rand(250000,50000000), rand(100000000,1000000000)];
        });
        return $range_price->first();
    }

    public static function getListTel(): Collection
    {
        $list_tels = collect(SimType::FILTER_TEL)->filter(function ($item) {
            return isset($item['t']);
        });
        $list_tels->transform(function ($item) {
            return [
                'id' => $item['t'],
                'name' => $item['name'],
            ];
        });
        return $list_tels;
    }

    public static function getSimTel($sim)
    {
        if(Str::length($sim)>3) {
            $sim = Str::substr($sim, 0, 3);
        }
        return collect(SimType::FILTER_TEL)->filter(function ($item) use($sim) {
            return isset($item['heads']) && in_array($sim, $item['heads']);
        })->first();
    }

    public static function getSimManufacture($sim): array
    {
        if(empty($sim['detail']['telcoText'])) {
            return SchemaConstant::MANUFACTURER;
        }
        return collect(SchemaConstant::MANUFACTURER)->filter(function ($item) use($sim) {
            return Str::ucfirst($sim['detail']['telcoText']) == $item['name'];
        })->all();
    }

    public function getSimValuation($sim): ?array
    {
        try {
            if(Str::length($sim) >= 10) {
                $api_valuation_url = config('constant.api_sim_url');
                $api_valuation_url = "$api_valuation_url/valuation/index?sim=$sim";
                $response = Http::get($api_valuation_url);
                if ($response->successful()) {
                    return $response->json();
                }
                return null;
            }
        } catch (\Illuminate\Http\Client\RequestException |
            \Illuminate\Http\Client\ConnectionException $exception) {
            $statusCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
            Helper::sendTelegramMsg(config('app.env'). "getSimValuation>> $statusCode >>> $errorMessage");
        }
        return null;
    }

    private function getAllInstallmentExists($sim): array
    {
        if(array_key_exists('inslm_info', $sim['detail'])){
            $installmentService = new SimInstallmentService();
            $ky_han = config('constant.sim_dep_tra_gop.tra_gop.ky_han');
            $tra_truoc = config('constant.sim_dep_tra_gop.tra_gop.tra_truoc');
            foreach ($ky_han as $key){
                foreach ($tra_truoc as $value){
                    $inslm_info = $installmentService->calculateInstallment($sim['detail'], $value, $key);
                    $sim['detail']['inslm_detail']['tra_truoc'][$value] = $inslm_info['so_tien_tra_truoc'];
                    $sim['detail']['inslm_detail']['ky_han'][$key][$value] = $inslm_info;
                }
            }
        }
        return $sim;
    }
    private function applyAllConditions($data, $priority_sims, WarehouseSetting $warehouseSetting, ?Request $request=null,array $simQueryObj=[]): array
    {
        // apply sim tra gop
        $data = $this->simInstallmentService->transform($data);
        // apply dieu chinh gia, neu sim la sim tra gop thi se ko adjust
        $adjustPrices = CacheModelService::getCustomPrice();
        foreach($data as $key => $item) {
            if (!array_key_exists('inslm_info', $item)) {
                $data[$key] = $this->checkAndAdjustInPriceRange($adjustPrices, $item);
            }
            // apply an so sim tren website
            if(count($warehouseSetting->sim_hidden) > 0 && in_array($item['id'], $warehouseSetting->sim_hidden)) {
                unset($data[$key]);
            }
            if(!empty($request) && method_exists($request, 'path') && Str::startsWith($request->path(),'tim-sim')){
                $data[$key] = static::highlightKeyword($simQueryObj, $item);
            }
        }
        // sap xep uu tien so len dau page
        if ($priority_sims) {
            $sortedObjects = [];
            foreach ($data as $item) {
                if (in_array($item['id'], $priority_sims)) {
                    array_unshift($sortedObjects, $item);
                } else {
                    $sortedObjects[] = $item;
                }
            }
            $data = $sortedObjects;
        }

        return $data;
    }
    private function checkAndAdjustInPriceRange($adjustPrices, $sim_item) {
        foreach($adjustPrices as $adjust_item) {
            if ($adjust_item->price_from <= $sim_item['pn'] && $sim_item['pn'] <= $adjust_item->price_to) {
                // lam tron gia sau khi giam VD: 854.050 -> 854.000
                $sim_item['sell_price'] = round(($sim_item['pn'] + $sim_item['pn'] * $adjust_item->percent/100), -3);
                $sim_item['adjust_percent'] = $adjust_item->percent;
                break;
            }
        }
        return $sim_item;
    }

    private static function highlightKeyword(array $simQueryObj, array $simData): array
    {
        if(isset($simQueryObj['tail']) or isset($simQueryObj['head']) or isset($simQueryObj['middle'])){
            // Loại bỏ thẻ i
            $simData['highlight'] = Str::of($simData['highlight'])->stripTags();
            if(isset($simQueryObj['tail']) and isset($simQueryObj['head'])){
                // highlight đầu số - đuôi số
                $simData['highlight'] = Str::highlightSearch($simData['highlight'], $simQueryObj['head']);
                $simData['highlight'] = Str::highlightSearch($simData['highlight'], $simQueryObj['tail'], 'end');
            }elseif (isset($simQueryObj['tail']) and !isset($simQueryObj['head'])){
                // highlight đuôi số
                $simData['highlight'] = Str::highlightSearch($simData['highlight'], $simQueryObj['tail'], 'end');
            }elseif (!isset($simQueryObj['tail']) and isset($simQueryObj['head'])){
                // highlight đầu số
                $simData['highlight'] = Str::highlightSearch($simData['highlight'], $simQueryObj['head']);
            }else{
                // highlight giữa số
                $simData['highlight'] = Str::highlightSearch($simData['highlight'], $simQueryObj['middle'], 'end');
            }
        }
        return $simData;
    }
}
