<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class TrailingSlashes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $flags = 'remove')
    {
        if(count($request->all()) > 0){
            $flags = 'remove';
        }
        if($flags == 'remove')
        {
            if($request->routeIs('homepage') && Str::length($request->getRequestUri()) > 1){
                return Redirect::to(config('app.url'), 301);
            }
            if(Str::endsWith($request->getRequestUri(), '/') && !$request->routeIs('homepage'))
            {
                return Redirect::to(config('app.url').Str::rtrim($request->getRequestUri(), '/'), 301);
            }
        }else{
            if (!preg_match('~(?:[^/]|^)/$~', $request->getRequestUri()))
            {
                return Redirect::away(Str::rtrim($request->getRequestUri(), '/').'/', 301);
            }
        }
        return $next($request);
    }
}
