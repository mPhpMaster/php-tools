<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/8/2019
 * Time: 03:11 ص
 */

namespace App\Utilities;


use App\Traits\ObjectAccess;
use Illuminate\Contracts\Support\Arrayable;

class ArrayObject extends \ArrayObject //implements Arrayable
{
    use ObjectAccess;

    public function __construct(array $data) {
        parent::__construct($data,ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
    }

    public function toArray(\Closure $callback = null)
    {
        $return = [];
        foreach (collect($this)->toArray() as $k=>$v) {
            $k = $v instanceof self && $v->getName() ? $v->getName() : $k;
            $return[ $k ] = ($v instanceof self) ? $v->toArray( $callback ) :
                ($callback != null ? $callback($k, $v) : $v);
        }

        return $return;
    }

    public static function makeArray($input) : array
    {
        return is_array($input) ? $input : [$input];
    }
}