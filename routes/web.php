<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\SimController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register'=>false,
]);

//Route::controller(SimController::class)->group(function () {
//
//    Route::get('dinh-gia-sim-ai', 'dinhGiaSimRoute');
//    Route::post('dinh-gia-sim-ai', 'dinhGiaSimRoute');
//
//    Route::get('thu-mua-sim-so-dep', 'thuMuaSimRoute');
//    Route::post('hoan-tat-dang-ban-sim.html', 'thuMuaSuccessSimRoute')->name('purchase.success');
//
//    Route::get('/hoan-tat-dat-sim.html', 'orderSuccessRoute')->name('order.success');
//    //middleware(['throttle:order-submit'])
//    Route::post('/dat-mua-sim/{sim}', 'orderRoute')
//        ->name('order.store')
//        ->where('sim', '[0-9]{10,11}');
//
//    //Route::middleware('cacheResponse')->group(function () {
//        Route::get('/', 'index')
//            ->name('homepage');
//
//        Route::get('sim-4g.html', 'simRoute');
//        Route::get('so-may-ban', 'simRoute');
//        Route::get('/tang-sim', 'simTangRoute');
//        Route::get('/tai-app.html', function () {
//            return view('theme.other.download-app');
//        });
//
//        Route::post('sim-phong-thuy', 'simPhongThuyRoute');
//        Route::post('xem-phong-thuy-sim', 'simPhongThuyRoute');
//        Route::get('sim-phong-thuy', 'simPhongThuyRoute')->name('sim-phong-thuy');
//        Route::get('xem-phong-thuy-sim', 'simPhongThuyRoute')->name('xem-phong-thuy-sim');
//        Route::get('sim-hop-tuoi-{tuoi}', 'simPhongThuyRoute')->name('sim-hop-tuoi');
//        Route::get('sim-hop-menh-{menh}', 'simPhongThuyRoute')->name('sim-hop-menh');
//
//        Route::get('tim-sim/{tail}.html', 'simRoute')
//            ->where(['tail'=> '[0-9]{1,12}']);
//        Route::get('tim-sim/{h}*{tail?}.html', 'simRoute')
//            ->where(['h'=> '[0-9]{1,8}','tail'=> '[0-9]{0,8}']);
//        Route::get('tim-sim/{h?}*{tail}.html', 'simRoute')
//            ->where(['h'=> '[0-9]{0,8}','tail'=> '[0-9]{1,8}']);
//        Route::get('tim-sim/{h?}*{mid}*{tail?}.html', 'simRoute')
//            ->where(['h'=> '[0-9]{1,8}', 'mid' => '[0-9]{1,8}', 'tail'=> '[0-9]{0,8}']);
//        Route::get('tim-sim/*{mid}*.html', 'simRoute')
//            ->where(['mid' => '[0-9]{1,9}']);
//        // chap nhan nam sinh tu 1950 - 2030
//        Route::get('sim-nam-sinh-{path}.html', 'simRoute')
//            ->where('path', '(19[5-9][0-9]|20[0-2][0-9]|2030)');
//        Route::get('sim-dau-so-{path}.html', 'simRoute')
//            ->where('path', '[0-9]{1,9}');
//        Route::get('sim-{path}', 'simRoute')
//            ->where('path', '[A-Za-z0-9\-_]+');
//    //});
//
//    Route::get('/{sim}', 'simDetailRoute')
//        ->where('sim', '[0-9]{10,11}');
//
//    Route::get('/{sim}.webp', 'simCardRoute')
//        ->where('sim', '[0-9]{10,11}');
//});
//
Route::controller(BlogController::class)->group(function() {
    Route::get('/', 'feature')
        ->middleware('slashes:add')
        ->name('blog.feature');
    Route::get('/chu-de/{slug}/{view?}', 'category')
        ->middleware('slashes:add')
        ->whereIn('view',['feed','json'])
        ->name('blog.category');
    Route::get('/tag/{slug}/{view?}', 'tag')
        ->middleware('slashes:add')
        ->whereIn('view',['feed','json'])
        ->name('blog.tag');
    Route::get('/author/{slug}/{view?}', 'author')
        ->middleware('slashes:add')
        ->whereIn('view',['feed','json'])
        ->name('blog.author');
    Route::get('search', 'search')->name('blog.search');
    Route::get('/{slug}/{view?}', 'post')
        ->middleware('slashes:add')
        ->where('slug', '^(?!admin).*')
        ->whereIn('view',['feed','json'])
        ->name('blog.post');
    Route::get('/{slug}/amp', 'amp')
        ->middleware('slashes:remove')
        ->name('blog.post.amp');
});
