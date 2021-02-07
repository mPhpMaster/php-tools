<?php

namespace App\Traits;


trait HasModelConfig
{
    public static function config($key = null, $default = null) {
        if (is_null($key)) {
            return config("ModelCrud");
        }

        if (is_array($key)) {
            $key = collect($key)->mapWithKeys(function ($v, $k) {
                return[
                        is_string($k) ? "ModelCrud.{$k}" : $k => $v
                ];
            })->toArray();
            return app('config')->set($key);
        }

        return app('config')->get("ModelCrud.{$key}", $default);
    }

    public static function modelConfig($key = null, $default = null) {
        $_key = "ModelCrud." . self::modelPath('.');

        if (is_null($key)) {
            return config($_key);
        }

        if (is_array($key)) {
            $key = collect($key)->mapWithKeys(function ($v, $k) use($_key) {
                return[
                        is_string($k) ? "{$_key}.{$k}" : $k => $v
                ];
            })->toArray();
            return app('config')->set($key);
        }

        return app('config')->get("{$_key}.{$key}", $default);
    }

}
