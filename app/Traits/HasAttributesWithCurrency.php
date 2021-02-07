<?php

namespace Modules\Tools\Traits;

/**
 * Trait HasAttributesWithCurrency
 *
 * @deprecated use {@link \Modules\Tools\Traits\THasAttributesWithString THasAttributesWithString} instead
 * @package Modules\Tools\Traits
 */
trait HasAttributesWithCurrency
{
    /**
     * **Override**
     *
     * $this->{any}_with_currency
     *
     * @param $key
     *
     * @return array|null|string
     */
    public function getAttribute($key, $currency = null)
    {
        $newKey = snake_case($key);
        // no overrides
        if (
            array_key_exists($key, $this->attributes) ||
            array_key_exists($newKey, $this->attributes) ||
            $this->hasGetMutator($key) ||
            $this->hasGetMutator($newKey)
        ) return parent::getAttribute($key);

        if (ends_with($newKey, '_with_currency')) {
            $newKey = str_before($newKey, '_with_currency');
            if (array_key_exists($newKey, $this->attributes) || $this->hasGetMutator($newKey)) {
                return $this->suffixWithCurrency($this->getAttribute($newKey), $currency);
            }
        }

        return parent::getAttribute($key);
    }

    /**
     * @param      $value
     * @param null $currency
     *
     * @return string|null
     */
    public function suffixWithCurrency($value, $currency = null)
    {
        $currency = $currency ?: __('global.riyal');
        $price = $value;
        $priceWC = empty(trim($price)) && trim($price) != '0' ?
            ''
            : __('global.price_with_currency', [
                'price' => $price,
                'currency' => $currency,
            ]);

        return $priceWC;
    }

    /**
     * @param null $currency
     * @param null $value
     *
     * @return string|object|null
     */
    public function withCurrency($currency = null, $value = null)
    {
        if (func_num_args() > 1) {
            return $this->suffixWithCurrency($value, $currency);
        }

        return new class ($this, $currency)
        {
            /** @var HasAttributesWithCurrency $class */
            protected $class;
            /** @var string $currency */
            protected $currency;

            /**
             * @param string|null $currency
             *
             * @return string|$this
             */
            public function currency(string $currency = null)
            {
                if (is_null($currency)) {
                    return $this->currency;
                } else {
                    $this->currency = $currency;
                }

                return $this;
            }

            /**
             *  constructor.
             *
             * @param $class
             * @param $currency
             */
            public function __construct($class, $currency)
            {
                $this->class = $class;
                $this->currency = $currency;
            }

            /**
             * @param $name
             *
             * @return array|string|null
             */
            public function __get($name)
            {
                return $this->class->suffixWithCurrency($this->class->{$name}, $this->currency);
            }

            /**
             * @param $name
             * @param $pars
             *
             * @return array|string|null
             */
            public function __call($name, $pars)
            {
                return $this->class->suffixWithCurrency($this->class->{$name}, head($pars) ?: $this->currency);
            }
        };
    }

    /**
     * @param $value
     *
     * @return string|object|null
     */
    public function getWithCurrencyAttribute($value)
    {
        return $this->withCurrency();
    }

}
