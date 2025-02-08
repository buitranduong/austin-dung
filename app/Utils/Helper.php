<?php
namespace App\Utils;

use App\Enums\SimType;
use App\Settings\WarehouseSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class Helper {
    // format money installment
    public static function getFilterActiveItems($request): array
    {
        $active_items = array();
        $active_keys = array();
        if (isset($_SERVER['QUERY_STRING'])) {
            $queryString = $_SERVER['QUERY_STRING'];
            $query_array =array();
            parse_str($queryString, $query_array);
            if (array_key_exists('h', $query_array)) {
                $h_arr = explode(",",$query_array['h']);
                foreach ($h_arr as $h) {
                    $active_h = false;
                    foreach (SimType::FILTER_HEAD as $item) {
                        if (strval($h)==$item['h']) {
                            $active_items[] = [
                                'title'=> $item['name'],
                                'key' => 'h',
                                'data' => $item['h']
                            ];
                            $active_keys[] = "h_".$item['h'];
                            $active_h = true;
                            break;
                        }
                    }
                    // neu key ko nam trong list FILTER_HEAD thi them truc tiep key do vao active_items
                    if(!$active_h) {
                        $active_items[] = [
                            'title'=> $h,
                            'key' => 'h',
                            'data' => $h
                        ];
                        $active_keys[] = "h_".$h;
                    }
                }
            }
            if (array_key_exists('c', $query_array)) {
                $c_arr = explode(",",$query_array['c']);
                foreach ($c_arr as $c) {
                    foreach (SimType::FILTER_CATES as $item) {
                        if ($item['c'] == $c) {
                            $active_items[] = [
                                'title'=> $item['title'],
                                'key' => 'c',
                                'data' => $item['c']
                            ];
                            $active_keys[] = "c_".$item['c'];
                            break;
                        }
                    }
                }
            }
            if (array_key_exists('t', $query_array)) {
                $t_arr = explode(",",$query_array['t']);
                foreach ($t_arr as $t) {
                    foreach (SimType::FILTER_TEL as $item) {
                        if ($item['t'] == $t) {
                            $active_items[] = [
                                'title'=> $item['title'],
                                'key' => 't',
                                'data' => $item['t']
                            ];
                            $active_keys[] = "t_".$item['t'];
                            break;
                        }
                    }
                }
            }
            if (array_key_exists('pr', $query_array)) {
                foreach (SimType::FILTER_PRICES as $item) {
                    if ($item['pr'] == $query_array['pr']) {
                        $active_items[] = [
                            'title'=> $item['name'],
                            'key' => 'pr',
                            'data' => $item['pr']
                        ];
                        $active_keys[] = "pr_".$item['pr'];
                        break;
                    }
                }
            }
            if (array_key_exists('d', $query_array) && $query_array['d']!=null) {
                $title= "";
                if($query_array['d']==-1) {
                    $title = "Giá thấp đến cao";
                } else if($query_array['d']==1) {
                    $title = "Giá cao đến thấp";
                } else if($query_array['d']==0) {
                    $title = "Mới cập nhật";
                }
                $active_items[] = [
                    'title'=> $title,
                    'key' => 'd',
                    'data' => $query_array['d']
                ];
                $active_keys[] = "d_".$query_array['d'];
            }
            if (array_key_exists('notIn', $query_array) && $query_array['notIn']!=null) {
                $title= "";
                $num_arr = explode(",",$query_array['notIn']);
                foreach ($num_arr as $num) {
                    $active_items[] = [
                        'title'=> "Tránh $num",
                        'key' => 'notIn',
                        'data' => $num
                    ];
                    $active_keys[] = "notIn_".$num;
                }
            }
        }
        return [
            'active_items'=>$active_items,
            'active_keys'=>$active_keys,
        ];
    }
    public static function getRequestParams($path, $seo_page, $request, $warehouseSetting): array
    {
        $query_array = [];
        $search_title = array();
        // trang home se truyen request null
        if ($request) {
            // xy ly cho các route tìm sim
            $h = $request->route('h');
            $mid = $request->route('mid');
            $tail = $request->route('tail');
            if ($h !== null) {
                $query_array['h'] = $h;
                $query_array['link'] = "/sim-dau-so-$h";
                $search_title[] = "đầu $h";
            }
            if ($mid !== null) {
                $query_array['mid'] = $mid;
                $cat_id = Helper::get_cate_by_keyword($mid, true);
                if ($cat_id) {
                    $query_array['c'] = $cat_id;
                }
                $query_array['link'] = "/sim-so-giua-$tail";
                $search_title[] = "giữa $mid";
            }
            if ($tail !== null) {
                $query_array['tail'] = $tail;
                $cat_id = Helper::get_cate_by_keyword($tail, false);
                if ($cat_id) {
                    $query_array['c'] = $cat_id;
                }
                $query_array['link'] = "/sim-duoi-so-$tail";
                $search_title[] = "đuôi $tail";
            }
            # xu ly query params
            if (isset($_SERVER['QUERY_STRING'])) {
                $query_array = array_merge($query_array, $request->query());
            }
        }
        $queryString = http_build_query($query_array, '', '&');
        $params = [];
        parse_str($queryString,$params);
        if(count($search_title)>0) {
            $search_title = implode(" ", $search_title);
            $params['title']= "Sim số đẹp $search_title";
        }
        $filter_params = Helper::getFilterData($path, $params);
        // neu ko match vs url nao thi lay $params
        if ($filter_params==null) {
            $filter_params = $params;
        }
        $filter_params_all= Helper::getPriorityPageParams($filter_params, $seo_page, $warehouseSetting, $path);
        return [
            'origin'=> $filter_params, // chi gom cac param tu url
            'all'=> $filter_params_all // tong hop ca param config trong admin page, setting
        ];
    }
    public static function getPriorityPageParams($filter_params, $seo_page, WarehouseSetting $setting, $path): array
    {
        $sim_setting = $seo_page->sim_setting ?? [];
        if (!array_key_exists('l_sec', $filter_params)) {
            $filter_params['l_sec'] = $setting->sim_update_lt_days ?? 61;
        }
        $telco_rates = $setting->percent_rates;
        // neu la trang tim kiem thi dung ti le rieng
        if (
            str_starts_with($path, '/tim-sim')
            or str_starts_with($path, '/sim-dau-so-')
            or str_starts_with($path, '/sim-tam-hoa-')
            or str_starts_with($path, '/sim-tu-quy-')
            or str_starts_with($path, '/sim-ngu-quy-')
            or str_starts_with($path, '/sim-luc-quy-')
            or str_starts_with($path, '/sim-hop-menh-')
        ) {
            $telco_rates = $setting->filter_percent_rates;
            //dd($telco_rates);
        }
        foreach ($telco_rates as $key => $value) {
            if ($value !== null) {
                $telco_rates[$key] = $value / 100;
            } else {
                $telco_rates[$key] = 0;
            }
        }
        // { "viettel": 0.5, "vinaphone": 0.5, "mobifone": 0, "vietnamobile": 0, "itel": 0, "gmobile": 0 }

        if (count($telco_rates)>0) {
            $filter_params['telco_rates'] = json_encode($telco_rates);
        }
        $is_only_warehouse = $setting->is_only_warehouse;
        $ignores_warehouse = $setting->ignores_warehouse;
        $gte = Helper::getPriorityFieldValue('priority_price_min', $sim_setting, $setting);
        $lte = Helper::getPriorityFieldValue('priority_price_max', $sim_setting, $setting);
        $t = Helper::getPriorityFieldValue('priority_provider', $sim_setting, null);
        $store = Helper::getPriorityFieldValue('priority_warehouse', $sim_setting, $setting);
        $priority_sims = Helper::getPriorityFieldValue('priority_sims', $sim_setting, $setting);
        $mandatory_query = $sim_setting['query'] ?? "";
        if (count($store)>0) {
            $filter_params['priority_stores'] = str_replace(' ','', implode(',', $store));
        }
        if ($is_only_warehouse && count($store)>0) {
            $filter_params['store'] = str_replace(' ','', implode(',', $store));
        }
        if (!array_key_exists('d', $filter_params)) {
            $d = Helper::getPriorityFieldValue('sort_default', $sim_setting, $setting);
            if ($d) {
                $filter_params['d'] = $d;
            }
        }
        if ($ignores_warehouse) {
            $filter_params['notStore'] = str_replace(' ','', implode(',', $ignores_warehouse));
        }
        $custom_query = [];
        if($gte) {
            $custom_query[] = "gte=$gte";
        }
        if($lte) {
            $custom_query[] = "lte=$lte";
        }
        if($t) {
            $custom_query[] = "t=$t";
        }
        if (count($custom_query)>0) {
            $filter_params['custom_query'] = implode('&', $custom_query);
        }
        if ($priority_sims && count($priority_sims)>0) {
            $filter_params['priority_sims'] = $priority_sims;
        }
        // mandatory query
        $mandatory_query_array=[];
        parse_str($mandatory_query, $mandatory_query_array);
        return array_merge($filter_params, $mandatory_query_array);
    }
    private static function getPriorityFieldValue($property, $sim_setting, $setting)
    {
        if ($sim_setting and property_exists($sim_setting, $property) and $sim_setting[$property]) {
            return $sim_setting[$property];
        } else if($setting and property_exists($setting, $property)){
            return $setting->{$property};
        }
        return null;
    }
    public static function getFilterData($path, $params_obj) {
        $filters = array_merge(SimType::FILTER_CATES,SimType::FILTER_PRICES, SimType::FILTER_TEL, SimType::FILTER_HEAD, SimType::FILTER_FATES, SimType::FILTER_CATE_OTHER);
        $filter_params = null;
        // query to all filters defined
        foreach ($filters as $filter) {
            if ($filter['link'] === $path) {
                $filter_params = array_merge($filter, $params_obj);
                // neu co h1 thi se lay theo h1, con ko lay title
                $filter_params['title'] = $filter_params['h1'] ?? $filter_params['title'];
                break;
            }
        }
        if(!$filter_params) {
            $filter = null;
            if (preg_match("/sim-theo-gia/", $path, $matches)) {
                // data query bang array query truyen vao
                $filter_params = $params_obj;
                if(isset($filter_params['pr'])){
                    [$begin, $end] = explode('-', $filter_params['pr']);
                    if((int)$begin > (int)$end){
                        abort(404);
                    }
                    $begin = number_format_short($begin, number_same_short($begin, $end));
                    $end = number_format_short($end);
                    $filter_params['link'] = "/$matches[0]";
                    $filter_params['title'] = "Sim số đẹp giá $begin - $end";
                    $filter_params['meta_data']['title'] = "Sim số đẹp giá $begin - $end";
                    $filter_params['meta_data']['meta']['description'] = "Kho Sim Số Đẹp giá từ 【{$begin}】 - 【{$end}】 tại kho SimThangLong.vn";
                }
                //dd($filter_params);
            }
            else if (preg_match("/tim-sim\/([0-9\*]+)/", $path, $matches)) {
                // data query bang array query truyen vao
                $filter_params = $params_obj;
                $filter_params['q'] = $matches[1];
                if(isset($matches[1])){
                    $seo_search = self::getSeoSearch($matches[1], $filter_params);
                    $filter_params['title'] = $seo_search['title'];
                    $filter_params['meta_data']['title'] = $seo_search['meta_data']['title'];
                    $filter_params['meta_data']['meta']['description'] = $seo_search['meta_data']['meta']['description'];
                }
                // dd($filter_params);
            }
            // sim dau so
            else if (preg_match("/sim-dau-so-(\d{1,9}).html/", $path, $matches)) {
                foreach (SimType::FILTER_HEAD as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        $filter['title'] = "Sim Đầu Số $matches[1]";
                        break;
                    }
                }
                if ($filter) {
                    $filter['h'] = $matches[1];
                    $filter['q'] = "$matches[1]*";
                } else {
                    $filter= [
                        'h' => $matches[1],
                        'title'=>"Sim đầu số $matches[1]"
                    ];
                }
                $filter_params= array_merge($filter, $params_obj);
            }

            // sim tien len dau
            else if (preg_match("/sim-tien-len-dau-(\d{2,})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['h'] = $matches[1];
                    $filter['q'] = "$matches[1]*";
                    $filter['title'] = $filter['title'] . " đầu " . $filter['h'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            // sim tien len duoi
            else if (preg_match("/sim-tien-len-duoi-(\d{2,})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $filter['q'] = $matches[1];
                    $cat_id = Helper::get_cate_by_keyword($matches[1], false);
                    if ($cat_id) {
                        $filter['c'] = $cat_id;
                    }
                    $filter['title'] = $filter['title'] . " đuôi " . $filter['tail'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            // sim tien len duoi dau
            else if (preg_match("/sim-tien-len-duoi-(\d{2,})-dau-(\d{2,})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $cat_id = Helper::get_cate_by_keyword($matches[1],false);
                    if ($cat_id) {
                        $filter['c'] = $cat_id;
                    }
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*$matches[1]";
                    $filter['title'] = $filter['title'] . " đuôi " . $filter['tail'] . " đầu " . $filter['h'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            // sim ngu quy
            else if (preg_match("/sim-ngu-quy-(\d{5})(-giua)?$/", $path, $matches)) {

                foreach (SimType::FILTER_CATES as $item) {
                    if(isset($matches[2])){
                        if ($item['link'] == '/sim-ngu-quy-giua') {
                            $filter = $item;
                            $filter['mid'] = $matches[1];
                            $filter['q'] = "*$matches[1]*";
                            $filter['title'] = $filter['title'] ." ". $matches[1] . " giữa";
                            break;
                        }
                    }else{
                        if ($item['link'] == $path || str_contains($path, $item['link'])) {
                            $filter = $item;
                            $filter['tail'] = $matches[1];
                            $filter['q'] = $matches[1];
                            $filter['title'] = $filter['title'] ." ". $matches[1];
                            break;
                        }
                    }
                }
                if ($filter) {
                    $filter_params = array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-ngu-quy-(\d{5})-dau-(\d{2,3})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $cat_id = Helper::get_cate_by_keyword($matches[1], false);
                    if ($cat_id) {
                        $filter['c'] = $cat_id;
                    }
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*$matches[1]";
                    $filter['title'] = $filter['title'] . ' ' . $matches[1] . ' đầu ' . $matches[2];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-ngu-quy-dau-(\d{2,4})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['h'] = $matches[1];
                    $filter['q'] = "$matches[1]*";
                    $filter['title'] = $filter['title'] . ' đầu ' . $matches[1];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-ngu-quy-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    foreach (SimType::FILTER_TEL as $item1) {
                        if ($item1['link'] == '/sim-' . $matches[1] || $item1['link'] == '/sim-so-dep-' . $matches[1]) {
                            $filter['t'] = $item1['t'];
                            $filter['title'] = $filter['title'] . ' ' . ucfirst($matches[1]);
                            break;
                        }
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-luc-quy-(\d{6})(-giua)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if(isset($matches[2])){
                        if ($item['link'] == '/sim-luc-quy-giua') {
                            $filter = $item;
                            $filter['mid'] = $matches[1];
                            $filter['q'] = "*$matches[1]*";
                            $filter['title'] = $filter['title'] ." ". $matches[1] . " giữa";
                            break;
                        }
                    }else{
                        if ($item['link'] == $path || str_contains($path, $item['link'])) {
                            $filter = $item;
                            $filter['tail'] = $matches[1];
                            $filter['q'] = $matches[1];
                            $filter['title'] = $filter['title'] ." ". $matches[1];
                            break;
                        }
                    }
                }
                if ($filter) {
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-luc-quy-(\d{6})-dau-(\d{2,3})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $cat_id = Helper::get_cate_by_keyword($matches[1], false);
                    if ($cat_id) {
                        $filter['c'] = $cat_id;
                    }
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*$matches[1]";
                    $filter['title'] = $filter['title'] . ' ' . $matches[1] . ' đầu ' . $matches[2];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-luc-quy-dau-(\d{2,4})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['h'] = $matches[1];
                    $filter['q'] = "$matches[1]*";
                    $filter['title'] = $filter['title'] . ' đầu ' . $matches[1];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-luc-quy-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    foreach (SimType::FILTER_TEL as $item1) {
                        if ($item1['link'] == '/sim-' . $matches[1] || $item1['link'] == '/sim-so-dep-' . $matches[1]) {
                            $filter['t'] = $item1['t'];
                            $filter['title'] = $filter['title'] . ' ' . ucfirst($matches[1]);
                            break;
                        }
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-tu-quy-(\d{4})(-giua)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if(isset($matches[2])){
                        if ($item['link'] == '/sim-tu-quy-giua') {
                            $filter = $item;
                            $filter['mid'] = $matches[1];
                            $filter['q'] = "*$matches[1]*";
                            $filter['title'] = $filter['title'] ." ". $matches[1] . " giữa";
                            break;
                        }
                    }else{
                        if ($item['link'] == $path || str_contains($path, $item['link'])) {
                            $filter = $item;
                            $filter['tail'] = $matches[1];
                            $filter['q'] = $matches[1];
                            $filter['title'] = $filter['title'] ." ". $matches[1];
                            break;
                        }
                    }
                }
                if ($filter) {
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-tu-quy-(\d{4})-dau-(\d{2,})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $cat_id = Helper::get_cate_by_keyword($matches[1], false);
                    if ($cat_id) {
                        $filter['c'] = $cat_id;
                    }
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*$matches[1]";
                    $filter['title'] = $filter['title'] . ' ' . $matches[1] . ' đầu ' . $filter['h'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-tu-quy-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    foreach (SimType::FILTER_TEL as $item1) {
                        if ($item1['link'] == '/sim-' . $matches[1] || $item1['link'] == '/sim-so-dep-' . $matches[1]) {
                            $filter['t'] = $item1['t'];
                            $filter['title'] = $filter['title'] . ' ' . ucfirst($matches[1]);
                            break;
                        }
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            // sim tam hoa
            else if (preg_match("/sim-tam-hoa-(\d{3})(-giua)?$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    if (!isset($matches[2])) {
                        // mac dinh lay duoi so
                        $filter['tail'] = $matches[1];
                        $filter['q'] = $matches[1];
                        $filter['title'] = $filter['title'] ." ". $matches[1];
                    } else{
                        // neu la giua
                        $filter['mid'] = $matches[1];
                        $filter['q'] = "*$matches[1]*";
                        $filter['title'] = $filter['title'] ." ". $matches[1] . " giữa";
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-tam-hoa-(\d{3})-dau-(\d{2,3})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*$matches[1]";
                    $filter['title'] = $filter['title'] . ' ' . $matches[1] . ' đầu ' . $filter['h'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-tam-hoa-dau-(\d{2,4})$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['h'] = $matches[1];
                    $filter['q'] = "$matches[1]*";
                    $filter['title'] = $filter['title'] . ' đầu ' . $matches[1];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-nam-sinh-(\d{4}).html/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == $path || str_contains($path, $item['link'])) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    $filter['tail'] = $matches[1];
                    $filter['q'] = $matches[1];
                    $filter['title'] = $filter['title'] . ' ' . $filter['tail'];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }

            else if (preg_match("/sim-([A-Za-z0-9-]{2,})+-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)$/", $path, $matches)) {
                foreach (SimType::FILTER_CATES as $item) {
                    if ($item['link'] == '/sim-' . $matches[1]) {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    foreach (SimType::FILTER_TEL as $item1) {
                        if ($item1['link'] == '/sim-' . $matches[2] || $item1['link'] == '/sim-so-dep-' . $matches[2]) {
                            $filter['t'] = $item1['t'];
                            $filter['title'] = $filter['title'] . ' ' . ucfirst($matches[2]);
                            break;
                        }
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }
            else if (preg_match("/sim-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)-dau-(\d{2,3})$/", $path, $matches)) {
                foreach (SimType::FILTER_TEL as $item) {
                    if ($item['link'] == "/sim-" . $matches[1]) {
                        $filter = $item;
                        break;
                    }
                }
                if (!empty($filter)) {
                    $filter['h'] = $matches[2];
                    $filter['q'] = "$matches[2]*";
                    $filter['title'] = $filter['title'] . " đầu " . $matches[2];
                    $filter_params= array_merge($filter, $params_obj);
                }
            }
            else if (preg_match("/sim-so-doc-(viettel|vinaphone|mobifone|itelecom|vietnamobile|gmobile)$/", $path, $matches)) {
                foreach (SimType::FILTER_CATE_OTHER as $item) {
                    if ($item['link'] == "/sim-so-doc") {
                        $filter = $item;
                        break;
                    }
                }
                if ($filter) {
                    foreach (SimType::FILTER_TEL as $item1) {
                        if ($item1['link'] == '/sim-' . $matches[1] || $item1['link'] == '/sim-so-dep-' . $matches[1]) {
                            $filter['t'] = $item1['t'];
                            $filter['title'] = $filter['title'] . ' ' . ucfirst($matches[1]);
                            break;
                        }
                    }
                    $filter_params= array_merge($filter, $params_obj);
                }
            }


            else if (preg_match("/sim-so-dep-dau-(\d{1,9})-giua-(\d{1,9})-duoi-(\d{1,9})$/", $path, $matches)) {
                $filter = array();
                $filter['h'] = $matches[1];
                $filter['mid'] = $matches[2];
                $filter['tail'] = $matches[3];
                $filter['q'] = "$matches[1]*$matches[2]*$matches[3]";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đầu " . $matches[1] . " giữa " . $matches[2] . " đuôi " . $matches[3];
                $filter_params= array_merge($filter, $params_obj);
            }

            else if (preg_match("/sim-so-dep-(\d{2,})-giua$/", $path, $matches)) {
                $filter = array();
                $filter['mid'] = $matches[1];
                $filter['q'] = "*$matches[1]*";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp " . $matches[1] . " giữa";
                $filter_params= array_merge($filter, $params_obj);
            }

            else if (preg_match("/sim-so-dep-duoi-(\d{1,})-dau-(\d{2,8})$/", $path, $matches)) {
                $filter = array();
                $filter['tail'] = $matches[1];
                $filter['h'] = $matches[2];
                $filter['q'] = "$matches[2]*$matches[1]";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đuôi " . $matches[1] . " đầu " . $matches[2];
                $filter_params= array_merge($filter, $params_obj);
            }

            else if (preg_match("/sim-so-dep-duoi-(\d{1,})-giua-(\d{2,8})$/", $path, $matches)) {
                $filter = array();
                $filter['tail'] = $matches[1];
                $filter['mid'] = $matches[2];
                $filter['q'] = "*$matches[2]*$matches[1]";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đuôi " . $matches[1] . " giữa " . $matches[2];
                $filter_params= array_merge($filter, $params_obj);
            }

            else if (preg_match("/sim-so-dep-dau-(\d{2,})-duoi-(\d{2,7})$/", $path, $matches)) {
                $filter = array();
                $filter['h'] = $matches[1];
                $filter['tail'] = $matches[2];
                $filter['q'] = "$matches[1]*$matches[2]";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đầu " . $matches[1] . " đuôi " . $matches[2];
                $filter_params= array_merge($filter, $params_obj);
            }

            else if (preg_match("/sim-so-dep-dau-(\d{2,})-giua-(\d{2,7})$/", $path, $matches)) {
                $filter = array();
                $filter['h'] = $matches[1];
                $filter['mid'] = $matches[2];
                $filter['q'] = "$matches[1]*$matches[2]*";
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đầu " . $matches[1] . " giữa " . $matches[2];
                $filter_params= array_merge($filter, $params_obj);
            }
            else if (preg_match("/sim-so-dep-duoi-(\d{1,9})$/", $path, $matches)) {
                $filter = array();
                $filter['tail'] = $matches[1];
                $filter['q'] = $matches[1];
                $filter['link'] = $path;
                $filter['title'] = "Sim số đẹp đuôi " . $matches[1];
                $filter_params= array_merge($filter, $params_obj);
            }
            // sim theo gia
//            else if (preg_match("/sim-(\d{1,15})-nghin-den-(\d{2,20})-nghin$/", $path, $matches)) {
//                $filter = [
//                    'pr'=> $matches[1]*1000 . '-' . $matches[2]*1000,
//                    'link'=> $path
//                ];
//                $params_obj['title'] = "Sim giá $matches[1] nghìn đến $matches[2] nghìn";
//                $filter_params= array_merge($filter, $params_obj);
//            }
            // sim theo gia
            // else if (preg_match("/sim-(\d{1,15})-nghin-den-(\d{1,20})-trieu$/", $path, $matches)) {
            else if (preg_match("/sim-(500)-nghin-den-(1)-trieu$/", $path, $matches)) {
                $filter = [
                    'pr' => $matches[1] * 1000 . '-' . $matches[2]*1000000,
                    'link'=> $path
                ];
                $params_obj['title'] = "Sim giá $matches[1] nghìn đến $matches[2] triệu";
                $filter_params= array_merge($filter, $params_obj);
            }
            // sim theo gia
            // else if (preg_match("/sim-(\d{1,15})-trieu-den-(\d{1,20})-trieu$/", $path, $matches)) {
            else if (preg_match("/sim-(1|3|5|10|50|100|200)-trieu-den-(3|5|10|50|100|200|500)-trieu$/", $path, $matches)) {
                $filter = [
                    'pr' => $matches[1] * 1000000 . '-' . $matches[2]*1000000,
                    'link'=> $path
                ];
                $params_obj['title'] = "Sim giá $matches[1] triệu đến $matches[2] triệu";
                $filter_params= array_merge($filter, $params_obj);
            }
        }
        return $filter_params;
    }

    // convert query object params to api sim.vn query params
    public static function convertURLParamsToAPIParams($params_obj = []): array
    {
        $obj = [];
        if (isset($params_obj['c']) && $params_obj['c']>0) {
            $obj['catId'] = $params_obj['c'];
        }

        if (isset($params_obj['acceptKhoAn'])) {
            $obj['acceptKhoAn'] = $params_obj['acceptKhoAn'];
        }

        if (isset($params_obj['h'])) {
            $obj['head'] = $params_obj['h'];
        }
        if (isset($params_obj['tail'])) {
            $obj['tail'] = $params_obj['tail'];
        }

        if (isset($params_obj['mid'])) {
            $obj['middle'] = $params_obj['mid'];
        }

        if (isset($params_obj['s'])) {
            $obj['store'] = trim($params_obj['s']);
        }

        if (isset($params_obj['t'])) {
            $obj['t'] = trim($params_obj['t']);
        }

        if (!empty($params_obj['query'])) {
            $obj['query'] = implode(',', $params_obj['query']);
        }

        if (!empty($params_obj['queryNotIn'])) {
            $obj['queryNotIn'] = implode(',', $params_obj['queryNotIn']);
        }

        if (isset($params_obj['p'])) {
            $obj['page'] = $params_obj['p'];
        }

        if (!empty($params_obj['d']) && $params_obj['d']!="0") {
            $obj['direction'] = $params_obj['d'];
            $obj['sortBy'] = 'pn';
        }
        // sort by phong thuy
        if (!empty($params_obj['sortBy']) && $params_obj['sortBy']=="pt") {
            unset($obj['direction']);
            $obj['sortBy'] = 'pt:desc';
            if (!empty($params_obj['d']) && $params_obj['d']!="0") {
                $direction = $params_obj['d'] == 1 ? 'desc' : 'asc';
                $obj['sortBy'] = 'pn:'.$direction.',pt:desc';
            }
        }

        if (isset($params_obj['notInCates'])) {
            $obj['notInCates'] = $params_obj['notInCates'];
        }
        // tranh so
        if (!empty($params_obj['notIn'])) {
            $obj['notIn'] = $params_obj['notIn'];
        }

        if (!empty($params_obj['limit'])) {
            $obj['limit'] = $params_obj['limit'];
        }

        if (!empty($params_obj['pr'])) {
            $obj['prices'] = $params_obj['pr'];
        }

        if (!empty($params_obj['cf'])) {
            $obj['catFate'] = $params_obj['cf'];
        }

        if (!empty($params_obj['yc'])) {
            $obj['yearCom'] = $params_obj['yc'];
        }
        if (!empty($params_obj['l_sec'])) {
            $obj['l_sec'] = $params_obj['l_sec'];
        }
        if (!empty($params_obj['priority_stores'])) {
            $obj['priority_stores'] = $params_obj['priority_stores'];
        }
        if (!empty($params_obj['store'])) {
            $obj['store'] = $params_obj['store'];
        }
        if (!empty($params_obj['notStore'])) {
            $obj['notStore'] = $params_obj['notStore'];
        }
        if (!empty($params_obj['custom_query'])) {
            $obj['custom_query'] = $params_obj['custom_query'];
        }
        if (!empty($params_obj['telco_rates'])) {
            $obj['telco_rates'] = $params_obj['telco_rates'];
        }
        $obj['price_key'] = "pn";
        return $obj;
    }

    public static function parseRelatedContent(array|string $content): array
    {
        $relatedContent = [];
        if(!is_array($content)){
            $content = preg_split('/\r\n|[\r\n]/', $content);
        }
        foreach ($content as $line) {
            $collection = Str::of($line)->explode('|');
            if($collection->count() == 2){
                $relatedContent[] = [
                    'title' => trim($collection[0]),
                    'link' => url(trim($collection[1])),
                ];
            }
        }
        return $relatedContent;
    }
    public static function getSeoSearch($keyword, $filter_params) {
        $str_sim_type = Helper::detectSimType($keyword);
        if ($str_sim_type!="") {
            // dd($str_sim_type);
            $title = $filter_params['title'] ?? '';
            return [
                'title' => "Sim ". $str_sim_type.' '.$keyword,
                'meta_data' => [
                    'title' => $title.' - SIM số đẹp '.$keyword,
                    'meta' => [
                        'description' => $title.' - '.__('Kho SIM số đẹp đuôi :tail mạng Viettel, Mobifone, Vinaphone, Vietnamobile, Gmobile, ITelecom chỉ từ 299k - Đăng ký chính chủ và giao SIM "miễn phí" tại nhà',['tail'=>$keyword])
                    ]
                ]
            ];
        } else {
            $attractKeyword = self::attractKeyword($keyword);
            $h = $attractKeyword['h'];
            $mid = $attractKeyword['mid'];
            $tail = $attractKeyword['tail'];
            $title = "";
            $meta_title="";
            $description = "";
            if ($tail != "") {
                if ($h != "") {
                    $title =  __('Sim số đẹp :h đuôi :tail',['tail'=>$tail, 'h'=>$h]);
                    $meta_title = __('Sim số đẹp :h đuôi :tail - Sim :keyword giá rẻ',['tail'=>$tail, 'h'=>$h, 'keyword'=>$keyword]);
                    $description = __('Sim :keyword - Sim đầu số :tail đuôi :h là 1 số sim đẹp thuộc mạng Viettel - Mua sim đuôi số 12 đầu 09812 được đăng ký chính chủ và giao sim miễn phí',['tail'=>$tail, 'h'=>$h, 'keyword'=>$keyword]);
                    if ($mid) {

                    }
                } else {
                    $title =  __('SIM đuôi :tail',['tail'=>$tail]);
                    $meta_title = __('SIM đuôi :tail - SIM số đẹp :tail',['tail'=>$tail]);
                    $description = __('SIM đuôi :tail - Kho SIM số đẹp đuôi :tail mạng Viettel, Mobifone, Vinaphone, Vietnamobile, Gmobile, ITelecom chỉ từ 299k - Đăng ký chính chủ và giao SIM &quot;miễn phí&quot; tại nhà',['tail'=>$keyword]);
                }
            } else if ($mid) {
                if ($h) {
                    $title =  __('SIM đuôi :mid giữa Đầu :h',['mid'=>$mid, 'h'=>$h]);
                    $meta_title = __('SIM đuôi :mid giữa Đầu :h giá rẻ tại Sim Thăng Long',['mid'=>$mid,'h'=>$h]);
                    $description = __('SIM đuôi :mid giữa Đầu :h giá rẻ tại Sim Thăng Long',['mid'=>$mid,'h'=>$h]);
                } else {
                    $title =  __('SIM đuôi :mid giữa',['mid'=>$mid]);
                    $meta_title = __('SIM đuôi :mid giữa - SIM số đẹp :mid giữa',['mid'=>$mid]);
                    $description = __('SIM đuôi :mid giữa - Kho SIM số đẹp đuôi :mid giữa mạng Viettel, Mobifone, Vinaphone, Vietnamobile, Gmobile, ITelecom chỉ từ 299k - Đăng ký chính chủ và giao SIM &quot;miễn phí&quot; tại nhà',['mid'=>$mid]);
                }
            }
            else if ($h) {
                $telco = self::getSimTel($h);
                $title =  __('SIM đầu số :h',['h'=>$h]);
                $meta_title = __('SIM :telco đầu :h - SIM đầu số :h chỉ từ 【199K】',['h'=>$h, 'telco'=>$telco['name'] ?? '']);
                $description = __('SIM đầu số :h thuộc dòng SIM số đẹp của nhà mạng Mobifone đang được bán chỉ từ 【199K】 tại Sim Thăng Long',['h'=>$h]);
            }
            return [
                'title' => $title,
                'meta_data' => [
                    'title' => $meta_title,
                    'meta' => [
                        'description' => $description
                    ]
                ]
            ];
        }
    }
    public static function attractKeyword($keyword) {
        $parts = explode("*", $keyword);
        // Extract the parts based on the number of elements in the resulting array
        if (count($parts) === 3) {
            $h = $parts[0];
            $mid = $parts[1];
            $tail = $parts[2];
        } elseif (count($parts) === 2) {
            $h = $parts[0];
            $tail = $parts[1];
        } else {
            $tail = $parts[0];
        }
        return [
            'h' =>isset($h) ? $h : "",
            'mid'=>isset($mid) ? $mid : "",
            'tail'=>isset($tail) ? $tail : ""
        ];
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
    public static function detectSimType(string $phone): string
    {
        if (Str::length($phone) > 6){
            return '';
        }

        $pattern="/(000000|111111|222222|333333|444444|555555|666666|777777|888888|999999)$/";
        if(preg_match($pattern,$phone)){
            return 'Lục quý';
        }

        $pattern="/(00000|11111|22222|33333|44444|55555|66666|77777|88888|99999)$/";
        if(preg_match($pattern,$phone)){
            return 'Ngũ quý';
        }

        $pattern="/(0000|1111|2222|3333|4444|5555|6666|7777|8888|9999)$/";
        if(preg_match($pattern,$phone)) {
            return 'Tứ quý';
        }

        $pattern="/(((\d{3})\\3)|([0-9](\d{2})[0-9]\\5)|(([0-9])\\7[0-9]([0-9])\\8[0-9])|((\d{2})\\10\\10)|(([0-9])\\12([0-9])\\13([0-9])\\14))$/";
        if(preg_match($pattern,$phone)){
            return 'Taxi';
        }

        $pattern="/(000|111|222|333|444|555|666|777|888|999)$/";
        if(preg_match($pattern,$phone)) {
            return 'Tam hoa';
        }

        $pattern="/(1268|1286|1186|2286|3386|4486|5586|6686|8886|9986|1168|2268|3368|4468|5568|6668|8868|9968|68168|68268|68368|68468|68568|68668|68768|68868|68968|861186|862286|863386|864486|865586|866686|867786|868886|869986|688|668|886|866|68|86)$/";
        if(preg_match($pattern,$phone)){
            return 'Lộc phát';
        }

        $pattern="/(3939|3979|7939|7979|6879|6679|8679|3339|779|3878|7838|6878|3338|3839|3879|7879|5679|3679|39|79|38)$/";
        if(preg_match($pattern,$phone)){
            return 'Thần tài';
        }

        $pattern="/(789|678|567|456|345|234|123|012)$/";
        if(preg_match($pattern,$phone)){
            return 'Tiến lên';
        }

        $pattern="/(5689|6689|6696|8898|8386|8689|8286|5569|1468|8699|8698|6698)$/";
        if(preg_match($pattern,$phone)){
            return 'Dễ nhớ';
        }

        $pattern="/((([0-9])([0-9])\4\3)|(([0-9])[0-9]\6))$/";
        if(preg_match($pattern,$phone)) {
            return 'Gánh đảo';
        }

        $pattern="/(((\d{2})\\3)|(([0-9])\\5([0-9])\\6))$/";
        if(preg_match($pattern,$phone)){
            return 'Lặp kép';
        }

        $pattern="/(2628|1368|1618|8683|5239|9279|3937|3938|3939|3333|8386|8668|4648|8888|4078|6666|3468|1668|7939|7838|7878|2879|1102|6789|6758|3737|4404)$/";//
        if(preg_match($pattern,$phone)){
            return 'Số độc';
        }

        return '';
    }
    public static function areAllDigitsSame($number) {
        $digits = str_split($number); // Convert number to an array of digits
        $firstDigit = $digits[0]; // Get the first digit

        foreach ($digits as $digit) {
            if ($digit !== $firstDigit) {
                return false; // Return false if any digit is different from the first digit
            }
        }

        return true; // Return true if all digits are the same
    }
    public static function get_cate_by_keyword($number, $is_mid) {
        $is_same_digits = self::areAllDigitsSame($number);
        if($is_same_digits) {
            $numberStr = (string) $number;
            $length = strlen($numberStr);
            $count = 1; // Initialize the count to 1

            for ($i = 1; $i < $length; $i++) {
                if ($numberStr[$i] !== $numberStr[0]) {
                    break;
                }
                $count++;
            }
            if($count==3) {
                return 80;
            } else if($count==4) {
                if ($is_mid) {
                    return 103;
                }
                return 68;
            }
            else if($count==5) {
                if ($is_mid) {
                    return 104;
                }
                return 99;
            } else if($count==6) {
                if ($is_mid) {
                    return 105;
                }
                return 100;
            }
        }
        return null;
    }
    public static function sendTelegramMsg($content) {
        if (config('app.env')=="production") {
            try {
                $telegramAPI = "https://agent-gateway.topsim.vn/telegram/send-notification";
                $data = [
                    'id' => '-4276102268',
                    'message' => $content
                ];
                $response = Http::post($telegramAPI, $data);
            } catch (\Exception $err) {
                echo "[SEND TELEGRAM MESSAGE ERROR] => " . $err->getMessage() . "\n";
            }
        }
    }
}
