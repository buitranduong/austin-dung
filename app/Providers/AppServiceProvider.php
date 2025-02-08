<?php

namespace App\Providers;

use Carbon\Carbon;
//use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(in_array(config('app.env'), ['production','staging']) && !request()->secure()) {
            URL::forceScheme('https');
        }
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super-Admin') ? true : null;
        });

        Carbon::setLocale('vi');

        Paginator::useBootstrapFive();

//        RateLimiter::for('order-submit', function (Request $request) {
//            $ip = $_SERVER['HTTP_X_REAL_IP'] ?? $request->getClientIp();
//            return Limit::perMinute(10, 5)->by($ip)->response(function (Request $request, array $headers) {
//                return response('Too Many Requests', 429, $headers);
//            });
//        });

        View::composer(
            'layouts.admin',
            'App\View\Composers\SidebarComposer'
        );

        View::composer(
            ['layouts.theme','theme.sim.*','theme.blog.*','theme.phongthuy.*'],
            'App\View\Composers\ThemeComposer'
        );

        View::composer(
            'theme.blog.*',
            'App\View\Composers\BlogComposer'
        );

        Request::macro('checkbox', function ($key, $checked = 1, $notChecked = 0) {
            return $this->input($key) ? $checked : $notChecked;
        });

        Request::macro('textarea', function ($key, $default = []) {
            return $this->input($key) ? preg_split('/\r\n|[\r\n]/', $this->input($key)) : $default;
        });

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'p') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage(1, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Collection::macro('sortByDate', function (string $column = 'published_at', bool $descending = true) {
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime(((object)$datum)->$column);
            }, SORT_REGULAR, $descending);
        });

        Str::macro('highlightSearch', function ($input, $number, $pos = 'start') {
            // Loại bỏ thẻ <i> hiện tại khỏi chuỗi
            //$input = preg_replace('/<i>(.*?)<\/i>/', '$1', $input);

            // Xóa các dấu chấm trong chuỗi để tìm vị trí của cụm số
            $plainInput = str_replace('.', '', $input);

            // Tìm vị trí của cụm số trong chuỗi không có dấu chấm
            // Nếu tìm theo đầu khớp theo vị trí đầu tiên được tìm thấy
            if($pos == 'start'){
                $pos = strpos($plainInput, $number);
            }else{
                // Khớp theo vị trí cuối cùng được tìm thấy
                $pos = strrpos($plainInput, $number);
            }

            // Nếu tìm thấy cụm số
            if ($pos !== false) {
                // Tạo một chuỗi trống để lưu kết quả
                $result = '';
                $counter = 0;

                // Lặp qua từng ký tự trong chuỗi gốc
                for ($i = 0; $i < strlen($input); $i++) {
                    // Nếu là dấu chấm thì thêm vào kết quả và bỏ qua
                    if ($input[$i] == '.') {
                        $result .= $input[$i];
                    } else {
                        // Nếu không phải dấu chấm, kiểm tra xem nó có nằm trong cụm số cần làm nổi bật không
                        if ($counter >= $pos && $counter < $pos + strlen($number)) {
                            // Nếu là ký tự đầu tiên của cụm số, thêm thẻ <i>
                            if ($counter == $pos) {
                                $result .= '<i>';
                            }
                            // Thêm ký tự hiện tại vào kết quả
                            $result .= $input[$i];
                            // Nếu là ký tự cuối cùng của cụm số, thêm thẻ </i>
                            if ($counter == $pos + strlen($number) - 1) {
                                $result .= '</i>';
                            }
                        } else {
                            // Thêm ký tự hiện tại vào kết quả
                            $result .= $input[$i];
                        }
                        // Tăng bộ đếm cho các ký tự không phải dấu chấm
                        $counter++;
                    }
                }
                return $result;
            }

            // Trả về chuỗi ban đầu nếu không tìm thấy cụm số
            return $input;
        });
    }
}
