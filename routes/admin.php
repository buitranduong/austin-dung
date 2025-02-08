<?php

use App\Http\Controllers\Admin\Blog\CategoryController;
use App\Http\Controllers\Admin\Blog\PageController;
use App\Http\Controllers\Admin\Blog\PostController;
use App\Http\Controllers\Admin\Blog\TagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Setting\RoleController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Setting\UserController;
use App\Http\Controllers\Admin\Seller\OrderController;
use App\Http\Controllers\Admin\Seller\SaleController;
use App\Http\Controllers\Admin\Seller\WarehouseController;
use App\Http\Controllers\Admin\Seo\MetaController;
use App\Http\Controllers\Admin\Seo\SeoController;
use App\Http\Controllers\Admin\Seo\FileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/system/info', function (){
    return phpinfo();
})->name('system.info');

Route::get('/artisan/optimize', function (){
    Artisan::call('optimize:clear');
    return redirect()->back()->with(['message'=>'Caching framework bootstrap, configuration, and metadata']);
})->name('artisan.optimize.clear');

Route::get('/artisan/cache', function (){
    Artisan::call('cache:clear');
    return redirect()->back()->with(['message'=>'Application cache cleared successfully']);
})->name('artisan.cache.clear');

Route::get('/artisan/responsecache', function (){
    Artisan::call('responsecache:clear');
    return redirect()->back()->with(['message'=>'Application Response cache cleared successfully']);
})->name('artisan.responsecache.clear');

Route::get('/artisan/opcache', function (){
    Artisan::call('opcache:compile',['--force'=>true]);
    return redirect()->back()->with(['message'=>'Application Response cache cleared successfully']);
})->name('artisan.opcache.compile');

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard.index');
});

Route::name('seller.')->prefix('seller')->group(function () {
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'index')->name('order.index');
        Route::get('/order/{id}', 'detail')->name('order.detail');
        Route::put('/order/{id}', 'rePush')->name('order.rePush');
        Route::post('/order/setting', 'setting')->name('order.setting');
    });

    Route::resource('sale', SaleController::class, [
        'parameters' => ['sale' => 'id'],
        'except' => ['show','create','edit']
    ]);

    Route::controller(WarehouseController::class)->group(function () {
        Route::get('/warehouse', 'index')->name('warehouse.index');
        Route::post('/warehouse', 'update')->name('warehouse.update');
    });
});

Route::name('seo.')->prefix('seo')->group(function () {
    Route::resource('page', SeoController::class, [
        'parameters' => ['page' => 'id'],
        'except' => ['show']
    ]);

    Route::controller(SeoController::class)->group(function () {
        Route::post('page/upload', 'upload')->name('page.upload');
        Route::patch('page/{id}/active', 'active')->name('page.active');
        Route::post('page/{id}/seo-meta', 'seoMeta')->name('page.seo-meta');
        Route::post('page/{id}/sim-setting', 'simSetting')->name('page.sim-setting');
    });

    Route::resource('meta', MetaController::class, [
        'parameters' => ['meta' => 'id'],
        'except' => ['show']
    ]);

    Route::resource('file', FileController::class, [
        'parameters' => ['file' => 'id'],
        'except' => ['show']
    ]);
});

Route::prefix('blog')->group(function () {
    Route::resource('post', PostController::class, [
        'parameters' => ['post' => 'id'],
        'except' => ['show']
    ]);
    Route::controller(PostController::class)->group(function () {
        Route::post('post/upload', 'upload')->name('post.upload');
        Route::post('post/{id}/seo-meta', 'seoMeta')->name('post.seo-meta');
        Route::get('post/trash', 'trash')->name('post.trash');
        Route::put('post/{id}/restore', 'restore')->name('post.restore');
        Route::delete('post/{id}/force-delete', 'forceDelete')->name('post.force-delete');
        Route::post('post/batch-action', 'handleBatchAction')->name('post.batch-action');
        Route::post('post/trash-batch-action', 'handleTrashBatchAction')->name('post.trash-batch-action');
        Route::post('post/edit/{id}', 'edit')->name('post.edit.filter');

    });

    Route::resource('page', PageController::class, [
        'parameters' => ['page' => 'id'],
        'except' => ['show']
    ]);
    Route::controller(PageController::class)->group(function () {
        Route::post('page/upload', 'upload')->name('page.upload');
        Route::post('page/{id}/seo-meta', 'seoMeta')->name('page.seo-meta');
        Route::get('page/trash', 'trash')->name('page.trash');
        Route::put('page/{id}/restore', 'restore')->name('page.restore');
        Route::delete('page/{id}/force-delete', 'forceDelete')->name('page.force-delete');
        Route::post('page/batch-action', 'handleBatchAction')->name('page.batch-action');
        Route::post('page/trash-batch-action', 'handleTrashBatchAction')->name('page.trash-batch-action');
    });
    Route::resource('category', CategoryController::class,  [
        'parameters' => ['category' => 'id'],
        'except' => ['show']
    ]);
    Route::controller(CategoryController::class)->group(function () {
        Route::post('category/{id}/seo-meta', 'seoMeta')->name('category.seo-meta');
        Route::patch('category/{id}/active', 'publish')->name('category.publish');
        Route::patch('category/{id}/featured', 'featured')->name('category.featured');
        Route::get('category/trash', 'trash')->name('category.trash');
        Route::put('category/{id}/restore', 'restore')->name('category.restore');
        Route::delete('category/{id}/force-delete', 'forceDelete')->name('category.force-delete');
    });

    Route::resource('tag', TagController::class, [
        'parameters' => ['tag' => 'id'],
        'except' => ['show']
    ]);
    Route::controller(TagController::class)->group(function () {
        Route::post('tag/{id}/seo-meta', 'seoMeta')->name('tag.seo-meta');
        Route::post('tag/{id}/seo-meta', 'seoMeta')->name('tag.seo-meta');
        Route::patch('tag/{id}/featured', 'featured')->name('tag.featured');
        Route::get('tag/trash', 'trash')->name('tag.trash');
        Route::put('tag/{id}/restore', 'restore')->name('tag.restore');
        Route::delete('tag/{id}/force-delete', 'forceDelete')->name('tag.force-delete');
    });
});

Route::prefix('setting')->group(function () {
    Route::resource('role', RoleController::class, [
        'parameters' => ['role' => 'id'],
        'except' => ['show']
    ]);

    Route::resource('user', UserController::class, [
        'parameters' => ['user' => 'id'],
        'except' => ['show']
    ]);
    Route::patch('user/{id}/active', [UserController::class, 'active'])->name('user.active');
    Route::post('user/upload', [UserController::class, 'upload'])->name('user.upload');

    Route::controller(SettingController::class)->group(function () {
        Route::get('/redirect', 'redirect')
            ->name('setting.redirect.index');
        Route::post('/redirect', 'redirect')
            ->name('setting.redirect.update');
        Route::get('/{group}', 'index')
            ->whereIn('group', ['index', 'blog'])
            ->name('setting.index');
        Route::post('/{group}', 'update')
            ->whereIn('group', ['index', 'blog'])
            ->name('setting.update');
    });
});
