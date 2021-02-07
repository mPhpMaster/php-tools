<?php

namespace Modules\Tools\Traits;

trait ClassHelpers
{
    public static function callParentMethod(
        $object,
        $class,
        $methodName,
        array $args = []
    )
    {
        $parentClass = get_parent_class($class);
        while ($parentClass) {
            if (method_exists($parentClass, $methodName)) {
                $parentMethod = new \ReflectionMethod($parentClass, $methodName);
                return $parentMethod->invokeArgs($object, $args);
            }
            $parentClass = get_parent_class($parentClass);
        }
    }

    public function forwardCallToParent()
    {
        $currentDebug = collect(debug_backtrace())->get(1);
        $method = $currentDebug['function'];
        if (!$method) {
            d(
                "cannot find method in ",
                debug_backtrace()
            );

            return false;
        }
        return self::callParentMethod($this, __CLASS__, $method, func_get_args());
    }

}
