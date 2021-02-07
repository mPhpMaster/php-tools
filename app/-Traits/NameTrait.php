<?php

namespace App\Traits;



trait NameTrait
{
    public function getNameAttribute(){
        return $this->attributes[ getColNameByLocale() ];
    }
}
