<?php

namespace App\Http\Controllers;

use App\Enums\OrderType;
use App\Enums\PaymentType;
use App\Enums\PhongThuyMenu;
use App\Models\Seller\SimOrders;
use App\Models\Seo\PageSeo;
use App\Services\CacheModelService;
use App\Services\GoogleScriptService;
use App\Services\ImageConvertService;
use App\Services\PhongThuyService;
use App\Services\SimService;
use App\Settings\OrderSetting;
use App\Settings\WarehouseSetting;
use App\Supports\Matomo\MatomoABTest;
use App\Supports\Meta\SchemaTag;
use App\Supports\Schema\SchemaProductCat;
use App\Supports\Schema\SchemaProductDetail;
use App\Utils\Helper;
use App\Utils\ReCaptcha;
use App\Utils\SeoMetaData;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\MetaTags\TagsCollection;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Spatie\SchemaOrg\MultiTypedEntity;
use Spatie\SchemaOrg\Schema;
use Illuminate\Support\Facades\Log;
//use App\Events\OrderCreated;

class SimController extends Controller
{
    private SimService $simService;
    private WarehouseSetting $warehouseSetting;

    public function __construct(SimService $simService, protected MetaInterface $meta, WarehouseSetting $warehouseSetting)
    {
        $this->simService = $simService;
        $this->warehouseSetting = $warehouseSetting;
        if($_GET){
            $this->meta->setRobots('noindex, noarchive');
        }
    }

    public function simRoute(Request $request, SchemaProductCat $schema)
    {
        $path = "/".$request->path();
        $seo_page = CacheModelService::getPageSeo($path, []);
        $filter = Helper::getRequestParams($path, $seo_page, $request, $this->warehouseSetting);
        // neu khong tim thay link sim dung
        if($filter['origin']==null or count($filter['origin'])==0 or !isset($filter['origin']['link'])) {
            abort(404);
        }
        $sim_data = $this->simService->getSims($filter['all'], $request, '', $this->warehouseSetting);
        if($request->ajax()){
            // set header fix issue show json if go back history browser
            return response()->json($sim_data)->header('Vary','Accept');
        }
        $seo_page = CacheModelService::getPageSeo($path, $filter['origin']);
        $sim_suggess = [];
        if($sim_data->total() > 0){
            if(isset($filter['origin']['priceRange'])){
                $seo_page->schema->minPrice = $filter['origin']['priceRange'][0];
                $seo_page->schema->maxPrice = $filter['origin']['priceRange'][1];
            }
            $seo_page->schema->offerCount = $sim_data->total();
        }else{
            if(preg_match("/tim-sim\/(\d+).html$/", $path, $match))
            {
                $tail = Str::substr($match[1], -6);
                $path = "/tim-sim/$tail.html";
                $filter = Helper::getRequestParams($path, [], $request, $this->warehouseSetting);
                // neu khong tim thay link sim dung
                if($filter['origin']==null or count($filter['origin'])==0) {
                    abort(404);
                }
                $filter['all']['tail'] = $tail;
                $filter['all']['path'] = $path;
                $filter['origin']['q'] = $match[1];
                $sim_suggess = $this->simService->getSims($filter['all'], $request, '', $this->warehouseSetting);
            }
        }
        $active_filter_items = Helper::getFilterActiveItems($request);
        if(!empty($seo_page->related_content)){
            $seo_page->related_content = Helper::parseRelatedContent($seo_page->related_content);
        }
        if(Str::startsWith($path, '/sim-theo-gia')){
            $this->meta->addMeta('robots',['content'=>'noindex, follow']);
            $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
        }else{
            $this->meta->setPaginationLinks($sim_data);
            $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
            $this->_useSchemaFaq($seo_page);
            $schemaTag = $schema->telCo($filter)->pageSeo($seo_page)->simData($sim_data)->toHtml();
            $this->meta->addTag('schema-product-cat', new SchemaTag($schemaTag));
        }
        $this->meta->includePackages(['styles','category']);
        $keyword = $filter['origin']['q'] ?? '';
        $heads = $filter['origin']['filter_mobile_heads'] ?? null;
        return view('theme.sim.list', compact('sim_data','sim_suggess', 'seo_page', 'path', 'active_filter_items', 'keyword', 'heads'));
    }
    public function simDetailRoute(Request $request, SchemaProductDetail $schema) {
        $sim = $request->route('sim');
        $sim_same = null;
        $sim_data = $this->simService->getSimDetail($sim, $this->warehouseSetting);
        if(empty($sim_data)) {
            $sim = ['id'=>$sim];
            $itel = $this->simService->getSimTel($sim['id']);
            if($itel){
                $sim['telco'] = $itel['telco'];
            }else{
                abort(404);
            }
            $sim['tail'] = Str::substr($sim['id'], 4);
            $sim['path'] = "/tim-sim/{$sim['tail']}.html";
            $request->route()->setParameter('tail', "{$sim['tail']}");
            $seo_page = CacheModelService::getPageSeo($sim['path'], ['title'=>"Sim {$sim['id']}"]);
            $filter = Helper::getRequestParams($sim['path'], $seo_page, $request, $this->warehouseSetting);
            // neu khong tim thay link sim dung
            if($filter['origin']==null or count($filter['origin'])==0) {
                abort(404);
            }
            $sim_same = $this->simService->getSims($filter['all'], $request, '', $this->warehouseSetting);
            $schema->simSold([
                'detail'=>[
                    'telcoText'=>$sim['telco'],
                    'id'=>$sim['id'],
                ],
                'title'=>"Sim {$sim['id']}",
                'description'=>"Sim {$sim['id']} thuộc nhà mạng {$sim['telco']}",
            ])->registerTags();
            $this->meta->setTitle("SIM {$sim['id']} đã bán - Sim Thăng Long");
        }else{
            CacheModelService::getSimSeo($sim_data);
            $this->meta->setTitle(strip_tags($sim_data['title']));
            $this->meta->setDescription(Str::replace('sSIMvn','SimThangLong',$sim_data['description']));
            $this->meta->setKeywords("{$sim_data['detail']['id']}, sim {$sim_data['detail']['id']}");
            $this->meta->addLink('canonical', ['href'=>url($sim_data['detail']['id'])]);
            $this->meta->addMeta('charset',['http-equiv'=>'Content-Type','content'=>'text/html; charset=utf-8']);
            $og = new OpenGraphPackage('social');
            $og->setType('website');
            $og->setSiteName(config('app.name'));
            $og->setTitle(strip_tags($sim_data['title']));
            $og->setDescription(Str::replace('sSIMvn','SimThangLong',$sim_data['description']));
            $og->addImage(config('constant.cdn_sim_card').'/'.$sim_data['detail']['id'].'.webp');
            $og->setLocale('vi_VN');
            $og->setUrl(url()->current());
            $this->meta->registerPackage($og);
            $seoMetaData = new SeoMetaData(null, $this->meta);
            $tags = new TagsCollection($seoMetaData->getScriptPlacements());
            $this->meta->registerTags($tags);
            $schemaTag = $schema->simData($sim_data)->toHtml();
            $this->meta->addTag('schema-product-detail', new SchemaTag($schemaTag));
        }
        $this->meta->includePackages(['sim_detail','detail']);
        return view('theme.sim.detail', compact('sim_data', 'sim','sim_same'));
    }
    public function simPhongThuyRoute(Request $request, string $slug = null)
    {
        $year = 1990;
        if($request->has('ft')) {
            $request->validate([
                'gt' => 'required|in:nam,nu',
                'ls' => 'required|integer|min:1950|max:2025',
                'ts' => 'required|in:'.implode(',', PhongThuyMenu::OPTION_THANG_SINH),
                'ns' => 'required|in:'.implode(',', PhongThuyMenu::OPTION_NGAY_SINH),
                'gs' => 'required|integer|min:0|max:23',
            ]);
            $content_data = PhongThuyService::laSoBatTu($request, $this->simService, $this->warehouseSetting);
            if(!empty($request->get('sim'))){
                $request->validate([
                    'sim' => ['required','regex:/^(0)([35789])+([0-9]{8})\b/'],
                ]);
                try {
                    $this->meta->setTitle("Kết quả phong thủy sim {$request->get('sim')}");
                    $this->meta->includePackages(['sim-phong-thuy','category']);
                    return view('theme.phongthuy.phong-thuy-detail', compact('content_data','year'));
                }catch (\Exception $exception){
                    return response()
                        ->view('theme.phongthuy.phong-thuy-detail',['content_data'=>[],'year'=>$year])
                        ->setStatusCode(404);
                }
            }
            $path = "/".$request->path();
            $seo_page = CacheModelService::getPageSeo($path, ['title'=>'Tìm Sim Phong Thủy']);
            $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
            $this->meta->includePackages(['sim-phong-thuy','category']);
            $active_filter_items = Helper::getFilterActiveItems($request);
            $keyword = $filter['origin']['q'] ?? '';
            $heads = $filter['origin']['filter_mobile_heads'] ?? null;
            $query = http_build_query($request->only(['gt','ls','ts','ns','gs','ft']), '', '&');
            return view('theme.phongthuy.phong-thuy-search', compact('content_data','seo_page','year','active_filter_items','keyword','heads','query'));
        }
        $path = "/".$request->path();
        $seo_page = CacheModelService::getPageSeo($path, ['title'=>'Tìm Sim Phong Thủy']);
        $sim_data = null;
        $active_filter_items = [];
        $keyword = '';
        $heads = null;
        if($slug)
        {
            $filter = Helper::getRequestParams($path, $seo_page, $request, $this->warehouseSetting);
            // neu khong tim thay link sim dung
            if($filter['origin']!=null and count($filter['origin'])>0) {
                $sim_data = $this->simService->getSims($filter['all'], $request, '', $this->warehouseSetting);
                if($request->ajax()){
                    // set header fix issue show json if go back history browser
                    return response()->json($sim_data)->header('Vary','Accept');
                }
                $seo_page = CacheModelService::getPageSeo($path, $filter['origin']);
                $active_filter_items = Helper::getFilterActiveItems($request);
                $keyword = $filter['origin']['q'] ?? '';
                $heads = $filter['origin']['filter_mobile_heads'] ?? null;
            }
        }
        if (preg_match("/sim-hop-tuoi-(\d{4})$/", $path, $matches)) {
            $year = $matches[1];
        }
        $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
        $this->meta->includePackages(['sim-phong-thuy','category']);
        return view('theme.phongthuy.phong-thuy', compact('seo_page','sim_data','path', 'active_filter_items', 'keyword', 'heads','year'));
    }

    public function dinhGiaSimRoute(Request $request)
    {
        $sim = old('sim');
        $valuation = null;
        if($request->isMethod('POST')) {
            $request->validate([
                'sim'=>['required','regex:/^(0)([35789])+([0-9]{8})\b/','max:10'],
            ]);
            $sim = $request->input('sim');
            $response = $this->simService->getSimValuation($sim);
            $valuation = Arr::get($response, 'data.valuation');
        }
        $path = "/".$request->path();
        $seo_page = CacheModelService::getPageSeo($path, ['title'=>'Định giá SIM AI']);
        $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
        $this->meta->includePackages(['styles','valuation']);
        return view('theme.sim.valuation', compact('seo_page','valuation','sim'));
    }

    public function index(Request $request)
    {
        $path = "/";
        $seo_page = CacheModelService::getPageSeo($path, []);
        // vs trang chu, se  truyen $request = null de ignore tham so param tren url
        $filter = Helper::getRequestParams($path, $seo_page, null, $this->warehouseSetting);
        $home_sim_block = $this->simService->getHomePageSimBlock($filter['all'], $request, $this->warehouseSetting);
        $seo_page = CacheModelService::getPageSeo($path, []);
        $this->_useSchemaFaq($seo_page);
        $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
        $this->meta->includePackages(['homepage','common']);
        return view('theme.sim.index', compact('seo_page', 'home_sim_block'));
    }

    private function _useMatomoScript(Request $request): void
    {
        $variation = $request->cookie('AB_cookie', 'A');
        $matomo = new MatomoABTest($variation == 'B' ? 'VariationB' : 'original');
        $this->meta->addTag('tracking-code', $matomo->trackingCode());
        $this->meta->addScript('tracking-js',
            $matomo->trackingScript(),
            [
                'defer' => true,
                'type' => 'text/javascript',
                'id' => $variation
            ],
            'head_script_after');
        $this->meta->addTag('ab-code', $matomo->ABCode());
    }

    private function _useSeoMetaTags(SeoMetaData $seoMetaData): void
    {
        $this->meta->setTitle($seoMetaData->getMetaTitle());
        $this->meta->setDescription($seoMetaData->getMetaDescription());
        $this->meta->setKeywords($seoMetaData->getMetaKeywords());
        $this->meta->setCanonical(url()->current());
        $this->meta->addMeta('charset',['http-equiv'=>'Content-Type','content'=>'text/html; charset=utf-8']);
        $tags = new TagsCollection($seoMetaData->getScriptPlacements());
        $this->meta->registerTags($tags);
        $og = new OpenGraphPackage('social');
        $og->setType('website');
        $og->setSiteName(config('app.name'));
        $og->setTitle(htmlspecialchars($seoMetaData->getMetaTitle()));
        $og->setDescription(htmlspecialchars($seoMetaData->getMetaDescription()));
        if ($seoMetaData->getFeaturedImage()){
            $og->addImage(asset("storage/{$seoMetaData->getFeaturedImage()}"));
        }
        $og->setLocale('vi_VN');
        $og->setUrl(url()->current());
        $this->meta->registerPackage($og);
    }

    private function _useSchemaFaq(?PageSeo &$seo_page): void
    {
        if(!empty($seo_page->faq) && count((array)$seo_page->faq) > 0){
            $mainEntity = [];
            foreach($seo_page->faq as $faq){
                $mainEntity[] = Schema::question()
                    ->name($faq['question'] ?? '')
                    ->url($faq['url'] ?? '')
                    ->acceptedAnswer(
                        Schema::answer()->text(Str::of($faq['answer'])->stripTags()->remove("\r\n") ?? '')
                    );
            }
            $schema = new MultiTypedEntity();
            $schema->FAQPage()->mainEntity($mainEntity);
            $seo_page->head_script_after .= $schema->toScript();
        }
    }

    public function orderRoute(Request $request, OrderSetting $orderSetting, Agent $agent, $sim)
    {
        $request->validate([
            'phone'=>['required','regex:/^(0)([35789])+([0-9]{8})\b/','max:10','not_in:'.$sim],
            'fullname'=>'required|max:255|min:2',
            'address'=>'required|max:255',
            'payment_method'=>'required|in:'.implode(',', PaymentType::values()),
            'order_type'=>'required|in:'.implode(',', OrderType::values()),
            'mst'=>'required_if:invoice,1'
        ]);
        $request->merge(['name' => $request->fullname]);
        if($sim){
            try{
                $simDetail = $this->simService->getSimDetail($sim, $this->warehouseSetting);
                if(!empty($simDetail['detail'])){
                    $simData = [];
                    $simData['sim'] = $simDetail['detail']['id'];
                    if(isset($simDetail['detail']['sell_price'])){
                        $simData['amount'] = $simDetail['detail']['sell_price'];
                    }else{
                        $simData['amount'] = $simDetail['detail']['pn'];
                    }
                    $simData['telco_id'] = $simDetail['detail']['t'];
                    $simData['ip'] = $_SERVER['HTTP_X_REAL_IP'] ?? $request->getClientIp();
                    $request->request->add($simData);
                    // check duplicate order
                    $orderedByPhone = SimOrders::where([
                        'sim'=>$sim,
                        'phone'=>$request->input('phone')
                    ])->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                        ->exists();
                    if($orderedByPhone){
                        return redirect()
                            ->back()
                            ->withErrors(['message'=>__("Bạn đã đặt sim số $sim gần đây rồi, vui lòng chọn sim số khác !")])
                            ->withInput();
                    }
                    // check black list
                    $is_spam = false;
                    $is_troll = false;
                    if($orderSetting->black_phone && in_array(trim($request->input('phone')), $orderSetting->black_phone))
                    {
                        Log::error("Warning: {$request->fullname} exists black list");
                        return redirect()
                            ->back()
                            ->withErrors(['message'=>__("Xin lỗi số điện thoại của bạn không thể đặt đơn lúc này !")])
                            ->withInput();
                    }
                    if($orderSetting->black_ip)
                    {
                        $platform = $agent->platform();
                        $browser = $agent->browser();
                        $version = $agent->version($browser);
                        foreach ($orderSetting->black_ip as $ip){
                            if(Str::contains($ip, '*')){
                                $ip = Str::remove('*', $ip);
                            }
                            if(Str::startsWith($simData['ip'], $ip))
                            {
                                $is_troll = true;
                                //$is_spam = true;
                                break;
//                                Log::error("Warning: {$ip} exists black list");
//                                return redirect()
//                                    ->back()
//                                    ->withErrors(['message'=>__("Xin lỗi IP của bạn không thể đặt đơn lúc này !")])
//                                    ->withInput();
                            }
                        }
                    }
                    if(!$is_spam){
                        $key = "order:{$simData['ip']}";
                        // Nếu validation thành công, kiểm tra giới hạn 3 yêu cầu / 15 phút
                        if (RateLimiter::tooManyAttempts($key, 3)) {
                            $is_spam = true;
                        }
                        // Ghi nhận 1 lần gửi khi hợp lệ
                        RateLimiter::hit($key, 900); // Giữ trạng thái trong 15 phút
                    }
                    $simOrder = new SimOrders();
                    $simOrder->fill($request->except('attributes'));
                    $browse_history = $request->input('browse_history') ?? "";
                    try {
                        $browse_history = json_decode($browse_history, true);
                        $browse_history[] = "USER_AGENT:" . $request->header('User-Agent');
                        if($request->input('_pk_id')){
                            $browse_history[] = "Matomo_Visitor_Id:" . $request->input('_pk_id');
                        }
//                        else{
//                            $is_troll = true;
//                            $browse_history[] = "Troll_Reason:Thiết bị nghi ngờ giả mạo";
//                        }
                        if($request->input('time_to_submit')){
                            $browse_history[] = "Time_To_Submit:" . $request->input('time_to_submit');
                        }
                        //$score = ReCaptcha::verify($request->input('_g_key'), $simData['ip'], 'order_submit');
                        //$browse_history[] = "Google_Score:" . $score;
//                        if(!empty($score) && $score <= 0.5){
//                            if($is_troll){
//                                $browse_history[] = "Troll_Reason:Địa chỉ IP trêu nhiều";
//                            }
//                            $is_troll = true;
//                            $browse_history[] = "Troll_Reason:Google chấm điểm thấp";
//                        }
                        if($is_troll){
                            $browse_history[] = "Troll_Reason:Địa chỉ IP trêu nhiều";
                            $browse_history[] = "Is_Troll:1";
                        }
                        $browse_history[] = json_encode($simDetail['detail']['s3']);
                        $simOrder->browse_history = $browse_history;
                    } catch (\Exception $exception) {}
                    if ($request->input('order_type') == OrderType::INSTALLMENT->value && $request->has('attributes')){
                        $attributes = (array)json_decode($request->input('attributes'), true);
                        $attributes['gia_goc'] = $simDetail['detail']['pn'];
                        $attributes['gia_ban'] = $simDetail['detail']['sell_price'] ?? $simDetail['detail']['pn'];
                        $simOrder->attributes = $attributes;
                    }else{
                        $simOrder->attributes = [
                            'gia_goc'=>$simDetail['detail']['pn'],
                            'gia_ban'=>$simDetail['detail']['sell_price'] ?? $simDetail['detail']['pn'],
                        ];
                    }
                    $simOrder->error = $is_spam;
                    $simOrder->save();
                    // dispatch event push to topsim
                    // event(new OrderCreated($simOrder, $simDetail['detail']));
                    // event(new OrderCreated($simOrder));
                    return redirect()->route('order.success')->with(['sim_order'=>$simOrder]);
                }
            } catch (\Illuminate\Http\Client\RequestException |
            \Illuminate\Http\Client\ConnectionException $exception) {
                $statusCode = $exception->getCode();
                $errorMessage = $exception->getMessage();
                Helper::sendTelegramMsg(config('app.env'). "getSimDetail>> $statusCode >>> $errorMessage");
                return null;
            } catch (\Exception $exception) {
                $statusCode = $exception->getCode();
                $errorMessage = $exception->getMessage();
                Helper::sendTelegramMsg(config('app.env'). "getSimDetail>> $statusCode >>> $errorMessage");
                return null;
            }
        }
        return redirect()->back()->withErrors(['message'=>__('Xin lỗi bạn, Sim này không còn trong kho!')]);
    }

    public function orderSuccessRoute(Request $request)
    {
        $sim_order = $request->session()->get('sim_order');
        if(!$sim_order) {
            return redirect()->route('homepage');
        }
        $this->meta->setTitle('Đặt sim thành công tại Sim Thăng Long');
        $seoMetaData = new SeoMetaData(null, $this->meta);
        $tags = new TagsCollection($seoMetaData->getScriptPlacements());
        $this->meta->registerTags($tags);
        $hidden_form_search = true;

        $currentTime = Carbon::now();
        $startTime = Carbon::createFromTime(); // 00:00
        $morningTime = Carbon::createFromTime(7, 30);
        $eveningTime = Carbon::createFromTime(22, 31);
        $endTime = Carbon::createFromTime(23, 59);
        if($currentTime->between($startTime, $morningTime)){
            $seller_message = 'Giao dịch viên sẽ gọi lại cho quý khách trước 7h45 sáng';
        }elseif ($currentTime->between($eveningTime, $endTime)){
            $seller_message = 'Giao dịch viên sẽ gọi lại cho quý khách trước 7h45 sáng ngày mai';
        }else{
            $seller_message = 'Trong 5 phút, giao dịch viên sẽ gọi lại cho quý khách';
        }
        $this->meta->includePackages(['sim_detail','order-success']);
        return view('theme.sim.order-success', compact('sim_order', 'hidden_form_search','seller_message'));
    }

    public function thuMuaSimRoute()
    {
        $success = false;
        $seo_page = new PageSeo();
        $seo_page->meta_data = [
            'title'=>'Thu mua - cho vay thế chấp sim số đẹp - Sim Thăng Long',
            'meta'=>[
                'description'=>'Thu mua sim và cho vay thế chấp bằng sim(hay còn gọi là "cầm cố sim") là dịch vụ chuyên nghiệp của simthanglong.vn dành cho khách hàng đang sử dụng sim số đẹp.'
            ]
        ];
        $this->_useSeoMetaTags(new SeoMetaData($seo_page, $this->meta));
        $this->meta->includePackages(['thu-mua-sim','common']);
        return view('theme.sim.purchase', compact('success'));
    }

    public function thuMuaSuccessSimRoute(Request $request, GoogleScriptService $service)
    {
        $request->validate([
            'hoten'=>'required|regex:/[0-9]{10,11}/', //sim
            'diachi'=>'required|regex:/^\d+(\.\d{1,2})?$/', //price
            'dienthoai'=>'required|regex:/[0-9]{10,11}/', //phone
        ]);
        $success = $service->pushData($request->except('_token'));
        $this->meta->includePackages(['thu-mua-sim','common']);
        $seoMetaData = new SeoMetaData(null, $this->meta);
        $tags = new TagsCollection($seoMetaData->getScriptPlacements());
        $this->meta->registerTags($tags);
        return view('theme.sim.purchase', compact('success'));
    }

    public function simTangRoute(Request $request)
    {
        $content = '';
        $queryParams = ['utm_source_prevent' => 'stlvn'];
        if(!empty($request->get('show'))){
            $queryParams['show'] = $request->get('show');
        }
        $url = "https://sim.vn/tang-sim?" . http_build_query($queryParams);
        $response = Http::get($url);
        if($response->successful()){
            $content = $response->body();
            $content = str_replace("/cdn-cgi", "https://sim.vn/cdn-cgi", $content);
        }
        if(!empty($content)){
            $script = <<<EOD
                <!-- Meta Pixel Code -->
                <script>
                    !function(f,b,e,v,n,t,s)
                    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,\'script\',
                    \'https://connect.facebook.net/en_US/fbevents.js\');
                    fbq(\'init\', \'1458131044769327\');
                    fbq(\'track\', \'PageView\');
                </script>
                <!-- End Meta Pixel Code -->
            EOD;
            // init script to head
            $content = str_replace("</head>", "{$script}</head>", $content);
            $noScript = <<<EOD
                <noscript><img alt="facebook" height="1" width="1" style="display:none"
                                src="https://www.facebook.com/tr?id=1458131044769327&ev=PageView&noscript=1"
                                /></noscript>
            EOD;
            // init noscript to body
            $content = preg_replace("/<body (.*)>/", "<body $1>{$noScript}", $content);
        }
        return response($content, 200)->header('Content-Type', 'text/html');
    }

    public function simCardRoute(ImageConvertService $imageConvertService, string $sim)
    {
        $sim_data = $this->simService->getSimDetail($sim, $this->warehouseSetting);
        if(!empty($sim_data['detail']))
        {
            $data = $imageConvertService->genSimCardNew($sim_data['detail']);
        }else{
            $simTel = Helper::getSimTel($sim);
            if(empty($simTel['telco'])){
                abort(404);
            }
            $simType = Helper::detectSimType($sim);
            $sim = Str::substrReplace($sim, '.', 4, 0);
            $sim = Str::substrReplace($sim, '.', 8, 0);
            $data = $imageConvertService->genSimCardNew([
                'pn'=>0,
                'telcoText'=>$simTel['telco'],
                'categoryText'=>$simType ?: 'Tự chọn',
                'highlight'=>$sim
            ]);
        }
        return response($data, 200, ['Content-Type'=>'image/webp']);
    }
}
