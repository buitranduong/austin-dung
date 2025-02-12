<?php

use App\Services\ImageConvertService;
use App\Settings\ImageSetting;
use Illuminate\Support\Str;
use magyarandras\AMPConverter\Util\ImageSize;
use Masterminds\HTML5;

if (!function_exists('format_money')) {
    function format_money($amount): string
    {
        return number_format($amount, 0, ',', '.'). '₫';
    }

}
if (!function_exists('format_money_k')) {
    function format_money_k($amount): string
    {
        $formatted = number_format(round($amount, -3), 0, ',', '.');
        if ($amount >= 1000) {
            $formatted = rtrim(rtrim($formatted, '0'), '.') . 'k';
        }
        return $formatted;
    }
}
if (!function_exists('array_item_startswith')) {
    function array_item_startswith($str, $array): bool
    {
        $hasItemStartingWithD = false;
        foreach ($array as $item) {
            //if (str_starts_with($item, $str) || $item==$str) {
            if ($item==$str) {
                $hasItemStartingWithD = true;
                break;
            }
        }
        return $hasItemStartingWithD;
    }
}
if (!function_exists('hung_cat_sim')) {
    function hung_cat_sim($str): string
    {
        $hungCatSim = config('constant.hung_cat_sim');
        $duoi4 = (int) substr($str, - 4);
        $duoi4 = $duoi4 % 80;
        if ($hungCatSim[$duoi4]['catid'] == 115) {
            return $hungCatSim[$duoi4]['diengiai'];
        }
        return '';
    }
}

if(!function_exists('feature_image'))
{
    function feature_image($path, $width, $height): string
    {
        $setting = new ImageSetting();
//        $dir = pathinfo($path, PATHINFO_DIRNAME);
//        $filename = pathinfo($path, PATHINFO_BASENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $image = str_replace(".{$ext}", "-{$width}x{$height}.{$setting->extension}", $path);
//        if(!file_exists(storage_path("app/public/{$dir}/{$image}"))) {
//            try {
//                $imageConvertService = app(ImageConvertService::class);
//                $imageConvertService->fromPath(storage_path("app/public/{$dir}/{$filename}"))
//                    ->convertAllSize(storage_path("app/public/{$dir}"));
//            }catch (Exception $e){}
//        }
        return asset("storage/$image");
    }
}

if(!function_exists('asset_image')){
    function asset_image(string $path): string
    {
        if(\Illuminate\Support\Str::startsWith($path, 'http')){
            $base_url = get_base_url($path);
            return \Illuminate\Support\Str::replace($base_url, url(''), $path);
        }
        return asset("storage/$path");
    }
}

if (!function_exists('get_base_url')){
    function get_base_url(string $url): string
    {
        if(!empty($url)){
            $url_info = parse_url($url);
            return $url_info['scheme'] . '://' . $url_info['host'];
        }
        return $url;
    }
}

if(!function_exists('get_gravatar_url')) {
    function get_gravatar_url($email): string
    {
        // Trim leading and trailing whitespace from
        // an email address and force all characters
        // to lower case
        $address = strtolower(trim($email));

        // Create an SHA256 hash of the final string
        $hash = hash('sha256', $address);

        // Grab the actual image URL
        return 'https://www.gravatar.com/avatar/' . $hash;
    }
}

if(!function_exists('replace_sim_seo'))
{
    function replace_sim_seo(string $string, array $sim): string
    {
        return preg_replace_callback('/\[sim.(.*?)]/', function ($m) use (&$sim) {
            return Str::of($sim[$m[1]])->stripTags() ?? '';
        }, $string);
    }
}

if(!function_exists('get_current_url'))
{
    function get_current_url(array $params): string
    {
        $currentUrl = request()->query();
        $allQueries = array_merge($currentUrl, $params);
        return request()->fullUrlWithQuery($allQueries);
    }
}

if(!function_exists('str_add_offset'))
{
    function str_add_offset(string $string, string $char, int|array $offset, int $length = 0): string
    {
        if (!empty($string)){
            if(is_array($offset)) {
                foreach ($offset as $position) {
                    $string = substr_replace($string, $char, $position, $length);
                }
            }else{
                $string = substr_replace($string, $char, $offset, $length);
            }
        }
        return $string;
    }
}

if(!function_exists('cdn_asset'))
{
    function cdn_asset(string $path): string
    {
        $cdn = config('constant.cdn_asset');
        if(!$cdn){
            return asset( $path );
        }
        $assetName = basename( $path );
        // Remove query string
        $assetName = explode("?", $assetName);
        $assetName = $assetName[0];
        // Select the CDN URL based on the extension
        foreach($cdn as $url => $types) {
            if(preg_match('/^.*\.(' . $types . ')$/i', $assetName))
            {
                return cdn_path($url, $path);
            }
        }
        // In case of no match use the last in the array
        end($cdn);
        return cdn_path(key($cdn), $path);
    }
}

if (!function_exists('cdn_path')) {
    function cdn_path($cdn, $asset): string
    {
        return  "//" . rtrim($cdn, "/") . "/" . ltrim( $asset, "/");
    }
}

if(!function_exists('schema_format')) {
    function schema_format(array $schema): string
    {
        return '<script type="application/ld+json">'.json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
    }
}

if(!function_exists('get_sim_tel'))
{
    function get_sim_tel(string $type): ?array
    {
        $tel = collect(\App\Enums\SimType::FILTER_TEL)->filter(function ($item) use ($type) {
            return isset($item['key']) && $item['key'] == $type;
        });
        if($tel->count() > 0){
            return $tel->first();
        }
        return collect(\App\Enums\SimType::FILTER_CATE_OTHER)->filter(function ($item) use ($type) {
            return isset($item['key']) && $item['key'] == $type;
        })->first();
    }
}

if(!function_exists('skip_keyword_comment'))
{
    function skip_keyword_comment(string $comment): string
    {
        $replace = array(
            'nứng' => 'Nương',
            'loz' => 'Long',
            'lolz' => 'Loan',
            'lone' => 'Luyến',
            'lồz' => 'Lợi',
            'lồn' => 'Liên',
            'Lồn' => 'Liên',
            'đĩ' => 'Đương',
            'Đĩ' => 'Đặng',
            'đỉ' => 'Đặng',
            'cặc' => 'Cao',
            'cc' => 'Cường',
            'ncc' => 'Ngân',
            'fuck' => 'Phong',
            'Fuck' => 'Phương',
            'bitch' => 'Bích',
            'Bitch' => 'Bích',
            'đụ' => 'Đăng',
            'Đụ' => 'Đăng',
            'đm' => 'Điều',
            'Đm' => 'Điều',
            'ĐM' => 'Điều',
            'dm' => 'Diệu',
            'Dm' => 'Diệu',
            'DM' => 'Diệu',
            'đmm' => 'Đoàn',
            'Đmm' => 'Đoàn',
            'dmm' => 'Đoàn',
            'Dmm' => 'Đoàn',
            'cl' => 'Cao',
            'clm' => 'Cao',
            'clmm' => 'Cương',
            'clgt' => 'Thế',
            'Clgt' => 'Thiệu',
            'đéo' => 'Đoàn',
            'Đéo' => 'Đoan',
            'test'=>'Thế'
        );
        return str_replace(array_keys($replace), $replace, $comment);
    }
}

if(!function_exists('extract_image_from_content'))
{
    function extract_image_from_content(string $content, int $minSize = 1000): array
    {
        $html5 = new HTML5([
            'disable_html_ns' => true
        ]);
        $doc = $html5->loadHTML($content);
        $query = '//img';
        $xpath = new \DOMXPath($doc);
        $entries = $xpath->query($query);
        $img_src = [];
        foreach ($entries as $tag) {
            if ($tag->hasAttribute('src')) {
                $imageSize = ImageSize::getImageSize(
                    url('/'),
                    $tag->getAttribute('src')
                );
                if(isset($imageSize['width']) && $imageSize['width'] > $minSize){
                    $img_src[] = asset($tag->getAttribute('src'));
                }
            }
        }
        return $img_src;
    }
}

if(!function_exists('blog_route'))
{
    function blog_route(...$route): string
    {
        return route(...$route).'/';
    }
}

if(!function_exists('xpath_string'))
{
    function xpath_string($input): string
    {

        if (!str_contains($input, "'")) {
            return "'$input'";
        }

        if (!str_contains($input, '"')) {
            return "\"$input\"";
        }

        return "concat('" . strtr($input, array("'" => '\', "\'", \'')) . "')";
    }
}

if(!function_exists('number_same_short'))
{
    function number_same_short(int $begin, int $end): bool
    {
        if(Str::length($begin) != Str::length($end)){
            return false;
        }
        if($begin < 1000000 and $end < 1000000){
            return true;
        }elseif($begin < 1000000000 and $end < 1000000000){
            return true;
        }elseif($begin < 1000000000000 and $end < 1000000000000){
            return true;
        }
        return false;
    }
}

if(!function_exists('number_format_short'))
{
    function number_format_short(int $number, bool $begin=false): int|string
    {
        if($number < 1000000){
            if ($begin){
                return round($number/1000);
            }
            return round($number/1000).'K';
        }elseif($number < 1000000000){
            if ($begin){
                return round($number/1000000);
            }
            return round($number/1000000).' triệu';
        }elseif($number < 1000000000000){
            if ($begin){
                return round($number/1000000000);
            }
            return round($number/1000000000).' tỷ';
        }
        abort(404, 'Khoảng giá không phù hợp!');
    }
}

include_once 'wp_helpers.php';
