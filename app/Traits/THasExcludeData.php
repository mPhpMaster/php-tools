<?php

namespace Modules\Tools\Traits;

/**
 * Trait THasExcludeData
 *
 * @package Modules\Tools\Traits
 */
trait THasExcludeData
{
    /**
     * exclude list.
     *
     * @var array
     */
    protected $exclude = [];

    /**
     * exclude limit. null = off
     *
     * @var int
     */
    protected $exclude_limit = null;

    /**
     * when exclude limit reached add exclude this.
     *
     * @var array
     */
    protected $exclude_on_limit = [];

    /**
     * when exclude limit reached use this as transformer.
     *
     * @var callable|null
     */
    protected $callback_on_exclude = null;

    /**
     * @return array
     */
    public function getExclude(bool $on_limit = false): array
    {
        return $on_limit ? $this->exclude_on_limit : $this->exclude;
    }

    /**
     * @param array $exclude
     *
     * @return static
     */
    public function setExclude(array $exclude, bool $on_limit = false)
    {
        if ( $on_limit ) {
            $this->exclude_on_limit = $exclude;
        } else {
            $this->exclude = $exclude;
        }

        return $this;
    }

    /**
     * @param array|string $key
     *
     * @return static
     */
    public function exclude($key, bool $on_limit = false)
    {
        $_key = $this->toKey((array)$key);
        $this->setExclude(array_unique(array_merge($this->getExclude($on_limit), $_key)), $on_limit);

        return $this;
    }

    /**
     * add the given key/keys to the exclude list after limit finish.
     *
     * @param array|string $key
     *
     * @return static
     */
    public function excludeOnLimit($key)
    {
        $this->exclude($key, true);

        if ( $this->hasExcludeLimit() ) {
            if ( !$this->isExcludeLimitReached() ) {
                return $this->setExcludeLimit($this->getExcludeLimit() - 1);
            }

            $this->setExclude(
                array_unique(array_merge(
                    $this->getExclude(),
                    $this->getExclude(true)
                ))
            );
        }

        return $this;
    }

    /**
     * @param string|null $key
     *
     * @return bool
     */
    private function isExcluded(?string $key = null, bool $is_exclude_on_limit = false): bool
    {
        $_key = ($has_any = ($key === '*' || is_null($key))) ? '*' : $this->toKey($key);

        if($has_any) {
            return !empty($this->getExclude($is_exclude_on_limit));
        }

        return  in_array($_key, $this->getExclude($is_exclude_on_limit), true) === true;

//        return (in_array('*', $this->exclude) === true) ||
//            ($key && !empty($this->exclude) && in_array($key, $this->exclude) === true);
    }

    /**
     * Parse the given method name to key name.
     *
     * @param string|string[]|null $method_name
     *
     * @return string|string[]
     */
    protected function toKey($method_name = null)
    {
        $get = is_array($method_name) ? 'toArray' : 'first';
        $_key = (array)$method_name;
        return toCollect($_key)->map(function ($method_name) {
            $method_name = getMethodName($method_name);
            $method_name = $this->isValidTransformMethodName($method_name) ? str_replace_first('transform', '', $method_name) : $method_name;

            return snake_case($method_name);
        })->$get();
    }

    /**
     * method_exists for ('transofrm' . $method_name)
     *
     * @param string $method_name
     *
     * @return bool
     */
    protected function isTransformExist(string $method_name): bool
    {
        return method_exists($this, $this->toTransformMethodName($method_name));
    }

    /**
     * check if the given method name is like "transformName"
     *
     * @param string|null $method_name
     *
     * @return bool
     */
    protected function isValidTransformMethodName(?string $method_name = null): bool
    {
        $method_name = getMethodName($method_name);

        return $method_name !== 'transform' && starts_with($method_name, 'transform');
    }

    /**
     * returns transformName from the given key.
     *
     * @param string $key
     *
     * @return string
     */
    protected function toTransformMethodName(string $key): string
    {
        $method_name = snake_case(trim($key));
        $method_name = !starts_with($method_name, 'transform') ? "transform_{$method_name}" : $method_name;

        return camel_case($method_name);
    }

    /**
     * execute all the custom transforms.
     *
     * @param array $data original transform data to merge the result with
     * @param mixed ...$args args to send to custom transforms.
     *
     * @return array
     * @throws \Throwable
     */
    public function loadAllCustomTransforms($data = [], ...$args): array
    {
        $methods = (array)getMethods($this);
        foreach ($methods as $method_name) {
            $key = $this->toKey($method_name);
            $method = $this->toTransformMethodName($key);
            $is_excluded = $this->isExcluded($method);

            if (
                !$method_name ||
                !$this->isValidTransformMethodName($method) ||
                // When Exclude Limit Reached
                $this->isExcludeLimitReached() ||

                $is_excluded ||
                !$this->isTransformExist($method)
            ) {
                if(!is_null($this->callback_on_exclude)) {
                    if ( is_callable($this->callback_on_exclude) ) {
                        $return = call_user_func($this->callback_on_exclude, $method, $this);
                        !is_null($return) && ($data[ $key ] = $return);
                    } else {
                        $data[ $key ] = $this->callback_on_exclude;
                    }
                }

                continue;
            }

//            if ( $this->isExcluded($method) || !$this->isTransformExist($method)/* || $this->isExcludeLimitReached()*/ ) {
//                continue;
//            }

            $data[ $key ] = $this->$method(...$args);
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function hasExcludeLimit(): bool
    {
        return !is_null($this->getExcludeLimit());
    }

    /**
     * @return int|null
     */
    public function getExcludeLimit(): ?int
    {
        return $this->exclude_limit;
    }

    /**
     * @param int|null $exclude_limit
     *
     * @return $this
     */
    public function setExcludeLimit(int $exclude_limit = null)
    {
        $this->exclude_limit = $exclude_limit;


        if ( !is_null($this->exclude_limit) && $this->exclude_limit < 0 ) {
            $this->exclude_limit = 0;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isExcludeLimitReached(): bool
    {
        return $this->hasExcludeLimit() && $this->getExcludeLimit() === 0;
    }

    /**
     * create new instnace with current limit &| excludeList.
     *
     * @param bool $withExcludeList
     * @param bool $withExcludeLimit
     *
     * @return $this
     */
    public function makeNewInstance($withExcludeList = true, $withExcludeLimit = true)
    {
        $instance = new static();

        if ( $withExcludeLimit ) {
            $instance->setExcludeLimit($this->getExcludeLimit());
            $instance->setExclude($this->getExclude(true), true);
        }

        if ( $withExcludeList ) {
            $instance->setExclude($this->getExclude());
        }

        return $instance;
    }
}
