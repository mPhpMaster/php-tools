<?php

namespace App\Traits;


trait HasModelAutoRegister
{
    use HasModelPaths;
    use HasModelRoutes;
    use HasModelPermissions;
    use HasModelListeners;
    use HasModelConfig;

    private static $isBooted = false;
    public static function onBoot() {
        if(self::$isBooted) return;

        self::$isBooted = true;
        self::$permissions = [
                'create'    => trim('create-' . self::getControllerPathToLowerCase('-')),
                'read'      => trim('read-' . self::getControllerPathToLowerCase('-')),
                'update'    => trim('update-' . self::getControllerPathToLowerCase('-')),
                'delete'    => trim('delete-' . self::getControllerPathToLowerCase('-'))
        ];

        self::setPath('view', self::getViewPathByController() . '.%s');
        self::setPath('route', self::getClassPluralLowerCase() . '.%s');
        self::setPath('lang', self::getViewPathByController() . '.%s');
    }

    public static function boot() {
        parent::boot();
        self::onBoot();

        if(Support()) {
            $ps = [];
            collect(self::$permissions)->each(function ($v, $k) use(&$ps) {
                if(!UserCan($v))
                    $ps[$k] = $v;
            });
            if(count($ps) > 0)
                du(
                        $ps,
                        __CLASS__
                );
        }
    }
}
