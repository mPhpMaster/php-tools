<?php

namespace App\Traits;


use App\Models\Model;

trait HasModelRoutes
{
    /**
     * return Controller::class;
     */
    abstract public static function getController();

    abstract public static function bootRouteWeb($prefix, $class);

    public static function getRouteResource($prefix = null, $class = null) {
        return \Route::resource($prefix?:self::getControllerPathToLowerCase("/"), $class?:self::getController());
    }

    public static function getRouteGetWithVar($method = 'index', $name = null) {
        $r = \Route::get(self::getRoutePathWithVar($method), self::getRoutePathWithUses($method));
        if($name)
            $r = $r->name(self::getClassPluralLowerCase() . '.' . $name);
        return $r;
    }
    public static function getRouteGet($method = 'index', $name = null) {
        $r = \Route::get(self::getRoutePathWithNoVar($method), self::getRoutePathWithUses($method));
        if($name)
            $r = $r->name(self::getClassPluralLowerCase() . '.' . $name);
        return $r;
    }

    public static function getRoutePathWithUses($type = null) {
        $model = self::getController();
        return "{$model}" . ($type ? "@{$type}" : "");
    }
    public static function getRoutePathWithVar($type = null) {
        $model = self::getModelNameVarInRoute();
        return self::getControllerPathToLowerCase("/") . ($type ? "/{{$model}}/{$type}" : "");
    }
    public static function getRoutePathWithNoVar($type = null) {
        return self::getControllerPathToLowerCase("/") . ($type ? "/{$type}" : "");
    }

    public static function getModelNameVarInRoute() {
        return strtolower(self::getModelName());
    }
    public static function getModelName() {
        return class_basename(__CLASS__);
    }
    public static function getClassPlural() {
        return ucfirst(str_plural(self::getModelName()));
    }
    public static function getClassPluralLowerCase() {
        return strtolower(str_plural(self::getModelName()));
    }

    public static function getControllerPath($delemetr = "\\", $controllerPath = null) {
        $controllerPath = $controllerPath ?: self::getController();
        $controllers = collect(explode("\\", $controllerPath))->reverse();
        $controller = [];
        $controllers->each(function($v) use(&$controller) {
            if(str_contains(strtolower($v), [
                    'controller',
                    'models',
                    'entities'
            ]))
                return false;
            else
                $controller[] = $v;
        });
        $controller = implode($delemetr, array_reverse($controller));

        return $controller;
    }
    public static function getControllerPathToLowerCase($delemetr = "\\", $controllerPath = null) {
        return strtolower(self::getControllerPath(...func_get_args()));
    }
    public static function getViewPathByController() {
        return strtolower(self::getControllerPath('.'));
    }
    public static function getLangPathByModel() {
        return strtolower(self::getControllerPath("\\", self::class));
    }
    public static function modelPath($delemetr = "\\") {
        return strtolower(self::getControllerPath($delemetr, self::class));
    }

    public static function trans($var) {
        return trans(self::transQuery() . '.' . $var);
    }
    public static function transQuery($var = null) {
        $var = $var ? ".{$var}" : "";
        return self::getLangPathByModel() . $var;
    }

    public static function bootRoute() {
        $prefix = self::getClassPluralLowerCase();
        $prefix = self::getControllerPathToLowerCase("/");
//        d(
//                $prefix,
//                self::getControllerPathToLowerCase()
//        );
        self::bootRouteWeb($prefix, self::getController());
    }
}
