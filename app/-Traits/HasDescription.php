<?php

namespace App\Traits;


trait HasDescription
{
    public function getDescriptionAttribute($value){
        if($value)
            return $value;
        return $this->{attrLocaleName("description")};
    }

    public function setDescriptionAttribute($value){
        $fill = array_flip($this->getFillable());

        if(array_key_exists('description_ar',$fill))
            $this->attributes['description_ar'] = $value;

        if(array_key_exists('description_en',$fill))
            $this->attributes['description_en'] = $value;

        if(array_key_exists('description',$fill))
            $this->attributes['description'] = $value;
    }
}
