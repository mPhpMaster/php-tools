<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 18/8/2019
 * Time: 07:10 ص
 */

namespace Modules\Cfg\Entities;


class Cfgrs {

    public $app;
    public function __construct($app) {
        $this->app = app($app);
    }
    public static function make($app) {
        return app($app);
    }
    public static function __callStatic($name, $arguments) {
        return self::make($name);
    }
}