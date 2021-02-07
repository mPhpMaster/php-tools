<?php

namespace App\Traits;


trait HasModelPaths
{
    public static function defaultPathFormat($type = '') {
        return sprintf(self::getClassPluralLowerCase() . '.%s', $type?:'%s');
    }

    public static $paths = [];
    public static function setPath($type = 'view', $path = "%s.index") {
        self::$paths[$type] = $path;
    }
    /**
     * = [
     *  'view' => '',
     *  'route' => '',
     *  'lang' => '',
     * ];
    */
    public static function path($type = null) {
        if(empty(self::$paths)) {
            try {
                self::onBoot();
            } catch (\Exception $exception) {

            }
        }

        $p = collect(self::$paths);
        $p = $type ? $p->get($type, self::defaultPathFormat()) : $p->toArray();
        return $p;
    }

    public static function viewPath($type = 'index') {
        $p = [
                self::path("view"),
                $type
        ];
        $p = sprintf(...$p);
        return $p;
    }

    public static function routePath($type = 'index') {
        $p = [
                self::path("route"),
                $type
        ];
        $p = sprintf(...$p);
        return $p;
    }

    public static function route($route) {
        return route(self::routePath($route));
    }

    public static function langPath($type = 'index') {
        $p = [
                self::path("lang"),
                $type
        ];
        $p = sprintf(...$p);
        return $p;
    }
}
