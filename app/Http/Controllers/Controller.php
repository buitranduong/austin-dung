<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getView($view, ?string $amp)
    {
        if ($amp == 'amp') {
            if (view()->exists($view . '-amp')) {
                $view .= '-amp';
            } else {
                abort(404);
            }
        }
        return $view;
    }
}
