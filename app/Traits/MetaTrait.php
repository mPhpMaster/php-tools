<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 18/12/2019
 * Time: 1:39 AM
 */

namespace Modules\Tools\Traits;

use Closure;
use InvalidArgumentException;
use RuntimeException;

trait MetaTrait
{

    private $methods = [];

    public function addMethod($methodName, $methodCallable)
    {
        if (!is_callable($methodCallable)) {
            throw new InvalidArgumentException('Second param must be callable');
        }
        $this->methods[$methodName] = Closure::bind($methodCallable, $this, get_class());
    }

    public function __call($methodName, array $args)
    {
        if (isset($this->methods[$methodName])) {
            return call_user_func_array($this->methods[$methodName], $args);
        }

        throw new RuntimeException('There is no method with the given name to call');
    }

}
