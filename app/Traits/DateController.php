<?php

namespace Modules\Tools\Traits;

trait DateController
{

    public function asDate($value)
    {
        return $value ? carbon()->parse($value)->toDateString() : null;
    }
}
