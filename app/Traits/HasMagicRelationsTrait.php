<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

trait HasMagicRelationsTrait{

    public function __get($name){
        $_name = substr($name, -5);
        $_trait = substr($name, -6);
        $_from_ = "_from_";
        if( strtolower($_name) == "_name" ){
            $method = str_before($name, $_name);
            if( ( $_n = $this->{$method} ) )
                return $_n->name;
        }
        elseif(
            strtolower($_trait) == "_magic"
            && str_contains( $name, $_from_)
        ){
            try{
                $logic = str_before($name, $_trait);
                list($attr,$method) = explode($_from_, $logic);
                if( method_exists($this, $method) && ( $relation = $this->{$method} ) ){
                    return $relation->{$attr};
                }
            }
            catch( \Exception $exception ){
                if( env("APP_DEBUG") ) dd($exception);
            }
        }

        return parent::__get($name);
    }

}
