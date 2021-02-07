<?php

namespace App\Traits;


trait HasToArrayName
{
    public function toArray(){
        $data = parent::toArray();
        $name = "";
        if(array_key_exists("name_{$this->getLocaleName()}" ,$data)){
            $name = $data["name_{$this->getLocaleName()}"];
        }

        $data['name'] = $name;
        return $data;
    }
}
