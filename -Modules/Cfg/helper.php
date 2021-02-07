<?php

if (! function_exists('cfg')) {
    function cfg($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('cfg');
        }

        if (is_array($key)) {
            return app('cfg')->put($key);
        }

        return app('cfg')->get($key, $default);
    }
}


collect(config('cfg.drivers.all'))->each(function($v) {
    app()->singleton(basename($v), function ($app) use($v){
        return new $v($app);
    });
});
