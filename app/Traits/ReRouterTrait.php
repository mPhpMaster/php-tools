<?php

namespace Modules\Tools\Traits;

trait ReRouterTrait
{
    /**
     * re route method
     *
     * @see \Modules\Tools\Interfaces\AbstractReRouter::reRoute
     */
    private function reRouted($method, $args)
    {
//        $method = $args[0];
//        array_shift($args);

        $method = getMethodName($method);
        $class = self::getReRouteClassName($args);

        return $class ? (app($class)->{$method}(...$args)) : false;
    }

    /**
     * @inheritdoc
     * @see \Modules\Tools\Interfaces\AbstractReRouter::reRoute
     */
    public function reRoute()
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

        $_CLASS = $this;
        $_ARGS = $_ORIGINAL_ARGS = func_get_args();
        array_unshift($_ARGS, $method);

        $callable = function () use (&$_CLASS, $_ORIGINAL_ARGS, $method) {
            return $_CLASS->reRouted($method, $_ORIGINAL_ARGS);
        };

        return $this->handleReRoute($callable, $_ARGS);
    }

    /**
     * @inheritdoc
     * @see \Modules\Tools\Interfaces\AbstractReRouter::handleReRoute()
     * @see \Modules\Tools\Traits\ReRouterTrait::handleReRoute()
     */
    public function handleReRoute($reRoute, ...$arguments)
    {
        // your code

        return $reRoute();
    }

}
