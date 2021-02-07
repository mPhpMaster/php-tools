<?php

namespace App\Http\ViewComposers;

use App\Http\Middleware\ViewAssign;
use Illuminate\Support\Str;
use Illuminate\View\View;

class All
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        ViewAssign::assign();

        $globalVars = [
                // Share user logged in
                'auth_user'             => $auth_user = AuthUser(),
                // Share date format
//                'date_format'           => $auth_user ? $this->getCompanyDateFormat() : 'd F Y',
                'viewMode'              => ViewMode()?: 'index',
        ];

        try {
            if(collect($view->getData())->get('model', false)) {
                $routeParameter = collect(CurrentRoute()->parameters)->first() ?: false;
//                $routeParameter = $routeParameter->count() ? $routeParameter->first() : [];
                $routeParameter = $routeParameter ? [ 'model' => $routeParameter ] : [];
            } else $routeParameter = [];

            $view->with($globalVars + $routeParameter);
        } catch (\Exception $exception) {
            $view->with($globalVars);
        }
    }
}
