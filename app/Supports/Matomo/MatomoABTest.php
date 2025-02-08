<?php

namespace App\Supports\Matomo;

use App\Supports\Meta\InlineScriptTag;

class MatomoABTest
{
    public function __construct(protected string $variation)
    {}

    public function trackingCode(): InlineScriptTag
    {
        $script = <<<END
            <!-- Matomo Code -->
            var _paq = window._paq = window._paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="https://simthanglong.matomo.cloud/";
                _paq.push(['setTrackerUrl', u+'matomo.php']);
                _paq.push(['setSiteId', '1']);
            })();
            <!-- End Matomo Code -->
        END;

        return new InlineScriptTag($script);
    }

    public function trackingScript(): string
    {
        return 'https://cdn.matomo.cloud/simthanglong.matomo.cloud/matomo.js';
    }

    public function ABCode(): InlineScriptTag
    {
        $script = <<<END
            function getCookie(cname) {
                let name = cname + "=";
                let ca = document.cookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                      c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                      return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            console.log(getCookie('AB_cookie'));
            <!-- Matomo AbTesting Code -->
            var _paq = window._paq = window._paq || [];
            _paq.push(['AbTesting::enter', {experiment: '8', variation: '$this->variation'}]);
            <!-- End Matomo AbTesting Code -->
        END;

        return new InlineScriptTag($script);
    }
}
