<?php
namespace App\Zex\Traits;


trait getObjectType
{
    /**
     * get self object Type
     *
     * @return string
     */
    public function getObjType(\stdClass $object = null) : string {
        return strtolower( class_basename(
            is_null($object) ? $this : $object
        ) );
    }
}