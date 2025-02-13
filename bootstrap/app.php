<?php

use App\Http\Middleware\RedirectRequests;
use App\Services\CacheModelService;
use App\Settings\GeneralSetting;
use App\Settings\HotlineSetting;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use DipeshSukhia\LaravelHtmlMinify\Middleware\LaravelMinifyHtml;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\EnsureAdminIsValid;
use App\Http\Middleware\TrailingSlashes;
use App\Utils\DetectAgent;
use Butschster\Head\Facades\Meta;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use App\Http\Middleware\TagsCacheResponse;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web','admin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(
            at: ['0.0.0.0/0'],
            headers: RequestAlias::HEADER_X_FORWARDED_FOR
        );
        $middleware->alias([
            'admin' => EnsureAdminIsValid::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'slashes' => TrailingSlashes::class,
            'doNotCacheResponse' => DoNotCacheResponse::class,
            'cacheResponse' => TagsCacheResponse::class,
        ]);
        $middleware->prependToGroup('web',[
            RedirectRequests::class,
        ]);
        $middleware->appendToGroup('web', [
            LaravelMinifyHtml::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'admin/blog/*'
        ]);
        $middleware->encryptCookies(except: [
            'AB_cookie'
        ]);
    })

    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (MethodNotAllowedHttpException $e) {
            return redirect('/');
        });
        $exceptions->renderable(function (\Exception $e, Request $request) {
            if ($e->getPrevious() instanceof TokenMismatchException) {
                Log::error('Error: 419', $request->all());
            };
        });
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            $hotlineSetting = new HotlineSetting();
            $generalSetting = new GeneralSetting();

            extract(DetectAgent::UseDevice());

            Meta::prependTitle(config('app.name'))
                ->setTitle('Đường link bạn truy cập hiện không tồn tại !')
                ->setDescription('Đường link bạn truy cập hiện không tồn tại !');
            $og = new OpenGraphPackage('social');
            $og->setType('website');
            $og->setSiteName(config('app.name'));
            $og->setTitle($generalSetting->site_name);
            $og->setDescription($generalSetting->site_description);
            //$og->addImage('https://simthanglong.vn/images/img_simthanglong.gif');
            $og->setLocale('vi_VN');
            $og->setUrl(url(''));
            Meta::registerPackage($og)
                ->includePackages(['homepage','common']);

            return response(view('errors.404')->with([
                'exception'=>$e,
                'htmlClass'=>$htmlClass,
                'homepage'=>$homepage,
                'phone'=>$phone,
                'mobile'=>$touch,
                'ipad'=>$ipad,
                'hotlineSetting'=>$hotlineSetting,
                'blogPostLatest'=>CacheModelService::getBlogPostsLatest(),
                //'postRecruitment'=>CacheModelService::getPostOfCategory('tuyen-dung')
            ]), $e->getStatusCode(), $request->headers->all());
        });
    })->create();
