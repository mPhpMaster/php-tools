<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


trait HasDescription
{
    /** Get description by locale
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDescriptionAttribute($value)
    {
        return
            isset($this->attributes[tool_title_locale('description')])
                ? $this->attributes[tool_title_locale('description')]
                : $value;
    }
}
