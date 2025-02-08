<?php

namespace App\Utils;

use Jenssegers\Agent\Agent;

class DetectAgent
{
    public static function UseDevice(): array
    {
        $agent = new Agent();
        $ua = $agent->getUserAgent();
        $phone = strstr($ua, 'iPhone') || strstr($ua, 'Android') && strstr($ua, 'Mobile') || strstr($ua, 'Windows Phone') || strstr($ua, 'BlackBerry');
        $touch = strstr($ua, 'iPhone') || strstr($ua, 'iPad') || strstr($ua, 'iPod') || strstr($ua, 'Android') || strstr($ua, 'Windows Phone') || strstr($ua, 'BlackBerry');
        $mouse = !$touch;
        $chrome = (bool)strstr($ua, 'Chrome');
        $firefox = str_contains($ua, 'Firefox');
        $safari = $mouse && !$chrome && strstr($ua, 'Safari') && strstr($ua, 'AppleWebKit');
        $iphone = $phone && strstr($ua, 'iPhone');
        $ipad = $touch && strstr($ua, 'iPad');
        $android = $touch && strstr($ua, 'Android');
        $ie = strstr($ua, 'MSIE') || strstr($ua, 'rv:11.0) like Gecko');
        $ie9 = (bool)strstr($ua, 'MSIE 9.0');
        $ie8 = (bool)strstr($ua, 'MSIE 8.0');

        $homepage = request()->routeIs('homepage');

        $htmlClass = ($mouse) ? 'mouse' : 'touch';
        if ($phone) $htmlClass = $htmlClass . ' phone';
        if (!$homepage) $htmlClass = $htmlClass . ' lower';
        if (!$ie9 && !$ie8) $htmlClass = $htmlClass . ' modern';
        if ($chrome) $htmlClass = $htmlClass . ' chrome';
        if ($firefox) $htmlClass = $htmlClass . ' firefox';
        if ($safari) $htmlClass = $htmlClass . ' safari';
        if ($iphone) $htmlClass = $htmlClass . ' iphone';
        if ($ipad) $htmlClass = $htmlClass . ' ipad';
        if ($android) $htmlClass = $htmlClass . ' android';
        if ($ie) $htmlClass = $htmlClass . ' ie';
        if ($ie9) $htmlClass = $htmlClass . ' ie9';
        if ($ie8) $htmlClass = $htmlClass . ' ie8';

        return [
            'htmlClass'=>$htmlClass,
            'homepage'=>$homepage,
            'phone'=>$phone,
            'touch'=>$touch,
            'ipad'=>$ipad,
        ];
    }

    public static function clientDevice(): string
    {
        $agent = new Agent();
        return $agent->deviceType();
    }
}
