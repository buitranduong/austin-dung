<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SimController;
use Illuminate\Support\Facades\URL;

Route::controller(SimController::class)->group(function () {
    Route::get('/signed', function (){
        // register route signed
        return URL::signedRoute('push-order-to-topsim');
    });
    Route::get('push-order-to-topsim', 'pushOrderJobAPI')
        ->name('push-order-to-topsim')->middleware('signed');
    Route::prefix('webhook-warehouse')->group(function () {
        Route::post('priority', 'webhookWarehousePriority');
        Route::post('ignores', 'webhookWarehouseIgnores');
    });
});
