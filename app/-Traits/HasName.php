<?php

namespace App\Traits;


trait HasName
{
    public function getNameAttribute($value){
        if($value)
            return $value;
        return $this->{'name_' . attrLocaleName()};
    }

    public function setNameAttribute($value){
        $fill = array_flip($this->getFillable());

        if(array_key_exists('name_ar',$fill))
            $this->attributes['name_ar'] = $value;

        if(array_key_exists('name_en',$fill))
            $this->attributes['name_en'] = $value;

        if(array_key_exists('name',$fill))
            $this->attributes['name'] = $value;
    }
}
