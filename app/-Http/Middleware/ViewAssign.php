<?php

namespace App\Http\Middleware;

use Closure;

class ViewAssign
{
    public static function assign(){
        $view = [
            "lang"      => app()->getLocale(),
            "align"     => starts_with(app()->getLocale(),"ar") ? "right": "left",
            "direction" => starts_with(app()->getLocale(),"ar") ? "rtl": "ltr",
        ];
        view()->share($view);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        d(
//                \Garf\LaravelConf\Models\Conf::class
//        );
        self::assign();
        return $next($request);
    }
}
