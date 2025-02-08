<?php

namespace App\Http\Middleware;

use App\Settings\RedirectSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RedirectRequests
{
    public function __construct(protected RedirectSetting $redirectSetting)
    {

    }
    public function handle(Request $request, Closure $next): Response
    {
        $url = Arr::first($this->redirectSetting->url_array, function ($data) use($request){
            $from = Str::remove(url('/'), $data['from']);
            $from = Str::trim($from, '/');
            return Str::endsWith($request->path(), $from);
        });
        if($url){
            if($url['code'] == 404) abort(404);
            return redirect()->to($url['to'], $url['code']);
        }
        return $next($request);
    }
}
