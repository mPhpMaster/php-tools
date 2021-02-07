<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/8/2019
 * Time: 03:08 ص
 */

namespace App\Traits;


trait ObjectAccess
{
//    private $array;

    public function __set($name, $value)
    {
        $this->{$name} = $value;

        return $this;
    }

    public function __get($name)
    {
        return isset($this->{$name}) ? $this->{$name} : null;
    }

    public function __isset($name)
    {
        return isset($this->{$name});
    }

    public function __unset($name)
    {
        unset($this->{$name});
    }

}