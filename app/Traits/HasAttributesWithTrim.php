<?php

namespace Modules\Tools\Traits;

/**
 * Trait HasAttributesWithTrim
 *
 * @property object with_trim
 *
 * @package Modules\Tools\Traits
 */
trait HasAttributesWithTrim
{
    /**
     *
     * @param string $value
     *
     * @return object
     */
    public function withTrim($value = null)
    {
        if (func_num_args() > 0) {
            return trim($value);
        }

        return new class ($this)
        {
            /** @var HasAttributesWithTrim $class */
            protected $class;

            /**
             *  constructor.
             *
             * @param $class
             */
            public function __construct($class)
            {
                $this->class = $class;
            }

            /**
             * @param $name
             *
             * @return string
             */
            public function __get($name)
            {
                return trim(data_get($this->class, $name));
            }

            /**
             * @param $name
             * @param $pars
             *
             * @return string
             */
            public function __call($name, $pars)
            {
                return trim(data_get($this->class, $name));
            }
        };
    }

    /**
     * @param $value
     *
     * @return object
     */
    public function getWithTrimAttribute($value)
    {
        return $this->withTrim();
    }

}
