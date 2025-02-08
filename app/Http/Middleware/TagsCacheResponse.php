<?php

namespace App\Http\Middleware;

use App\Utils\DetectAgent;
use Closure;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Events\CacheMissed;
use Spatie\ResponseCache\Exceptions\CouldNotUnserialize;
use Spatie\ResponseCache\Middlewares\CacheResponse;
use Symfony\Component\HttpFoundation\Response;

class TagsCacheResponse extends CacheResponse
{
    public function handle(Request $request, Closure $next, ...$args): Response
    {
        $lifetimeInSeconds = $this->getLifetime($args);

        if (!count($args)){
            $args = [config('responsecache.cache_lifetime_in_seconds'), DetectAgent::clientDevice(), $request->cookie('AB_cookie','original')];
        }
        $tags = $this->getTags($args);

        if ($this->responseCache->enabled($request) && ! $this->responseCache->shouldBypass($request) && ! $request->ajax()) {
            try {
                if ($this->responseCache->hasBeenCached($request, $tags)) {

                    $response = $this->getCachedResponse($request, $tags);
                    if ($response !== false) {
                        return $response;
                    }
                }
            } catch (CouldNotUnserialize $e) {
                // report("Could not unserialize response, returning uncached response instead. Error: {$e->getMessage()}");
                event(new CacheMissed($request));
            }
        }

        $response = $next($request);

        if ($this->responseCache->enabled($request) && ! $this->responseCache->shouldBypass($request) && ! $request->ajax()) {
            if ($this->responseCache->shouldCache($request, $response)) {
                $this->makeReplacementsAndCacheResponse($request, $response, $lifetimeInSeconds, $tags);
            }
        }

        event(new CacheMissed($request));

        return $response;
    }
}
