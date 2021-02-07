<?php

namespace App\Traits;


trait HasDisplayName
{
    public function getDisplayNameAttribute($value){
        if($value)
            return $value;
        return $this->{attrLocaleName("display_name")};
    }

    public function setDisplayNameAttribute($value){
        $fill = array_flip($this->getFillable());

        if(array_key_exists('display_name_ar',$fill))
            $this->attributes['display_name_ar'] = $value;

        if(array_key_exists('display_name_en',$fill))
            $this->attributes['display_name_en'] = $value;

        if(array_key_exists('display_name',$fill))
            $this->attributes['display_name'] = $value;
    }

}
