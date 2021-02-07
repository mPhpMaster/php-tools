<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

trait HasName{

    /**
     * Get name by locale
     * @param $value
     * @return mixed
     */
    public function getNameAttribute($value){
        return $value ? $value : $this->{tool_title_locale()};
        isset($this->attributes[tool_title_locale()])
            ? ucfirst($this->attributes[tool_title_locale()])
            : ucfirst($value);
    }
}
