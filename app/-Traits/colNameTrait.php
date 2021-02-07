<?php

namespace App\Traits;


//TODO: colNameTrait
trait colNameTrait
{
    protected
        $col_name_separation = "_",
        $col_val_name = "name";

    // $this::colName(): get col name
    public static function colName(){
        return "name";
    }

    // $this->colName = "name"
    public function setColNameAttribute(string $col_val_name = "name")
    {
        $this->col_val_name = !empty($col_val_name) ? $col_val_name : "name";
        return $this;
    }

    // $this->>name: get name by locale
    public function getNameAttribute(){
        return $this->attributes[ getColNameByLocale($this->col_val_name . $this->col_name_separation) ];
    }

    // $this->>value: get value by locale
    public function getValueAttribute(){
        return $this->name;
    }
}
