<?php

namespace App\Traits;


trait HasModelPermissions
{
    public static $permissions        = [
            'create' => '',
            'read' => '',
            'update' => '',
            'delete' => '',
    ];

    public static function PermissionName($type = null) {
        self::onBoot();

        $p = collect(self::$permissions);
        if($type == '*')
            $p = $p->values()->toArray();
        else
            $p = $type ? $p->get($type, null) : $p->toArray();

        return $p;
    }
}
