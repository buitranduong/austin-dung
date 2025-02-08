<?php

namespace App\View\Composers;

use App\Services\CacheModelService;
use App\Settings\GeneralSetting;
use App\Settings\HotlineSetting;
use App\Utils\DetectAgent;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class ThemeComposer
{
    public function __construct(
        protected Agent $agent,
        private readonly HotlineSetting $hotlineSetting,
        private readonly GeneralSetting $generalSetting,
    ){}

    public function compose(View $view): void
    {
        extract(DetectAgent::UseDevice());

        $view->with([
            'htmlClass'=>$htmlClass,
            'homepage'=>$homepage,
            'phone'=>$phone,
            'mobile'=>$touch,
            'ipad'=>$ipad,
            'hotlineSetting'=>$this->hotlineSetting,
            'generalSetting'=>$this->generalSetting,
            'blogPostLatest'=>CacheModelService::getBlogPostsLatest(),
            //'postRecruitment'=>CacheModelService::getPostOfCategory('tuyen-dung'),
            'simOrderLatest'=>CacheModelService::getLatestOrder(),
            'abTest'=>Cookie::get('AB_cookie', 'original'),
        ]);
    }
}
