<?php

namespace Modules\Tools\Traits;

use Modules\Tools\Entities\Names;

/**
 * Created by PhpStorm.
 * User: MyTh
 * Date: 16/4/2019
 * Time: 9:15 AM
 */
trait HasToolsNames
{
    public function writeTools($data = [])
    {
        return $this->toolsName()
            ->updateOrCreate(
                [
                    "nameable_type" => self::class,
                    "nameable_id" => $this->id,
                ],
                $data
            );
    }

    public function toolsName()
    {
        return $this->morphOne(Names::class, 'nameable');
    }

    /**
     * $this->name
     *
     * @param $value
     *
     * @return string
     */
    public function getNameAttribute($value)
    {
        return $value ? $value : ($this->toolsName ? $this->toolsName->{tool_title_locale()} : "");
    }

    /**
     * $this->description
     *
     * @param $value
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return $value ? $value : ($this->toolsName ? $this->toolsName->{tool_title_locale('description')} : "");
    }
}
