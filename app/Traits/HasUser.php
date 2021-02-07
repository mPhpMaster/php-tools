<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use Modules\User\Entities\User;

trait HasUser
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * $this->user_name
     *
     * @param $value
     *
     * @return mixed
     */
    public function getUserNameAttribute($value)
    {
//        dd($this,$value,$this->user);
        $r = ($r = $this->user) ? $r->name : $value;
        $r = (($r ?: __("global.null")) == "global.null") ? "" : $r;

        return $r;
    }

    /**
     * $this->userData()
     *
     * @param $value
     *
     * @return mixed
     */
    public function userData($column, $default = UNUSED)
    {
        $default = isUsed($default) ? $default : __("global.null");

        $r = ($r = $this->user) ? $r->{$column} : $default;
        $r = (($r ?: $default) == "global.null") ? "" : $r;

        return $r;
    }
}
