<?php

namespace Modules\Tools\Traits;

use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\ArraySerializer;

/**
 * Trait DefaultsForFractalables
 *
 * @package Modules\Tools\Traits
 */
trait DefaultsForFractalables
{

    /**
     * @var null|SerializerAbstract $defaultSerializer
     */
//    protected static $defaultSerializer;
    /**
     * @var null|callable|TransformerAbstract $defaultTransform
     */
//    protected static $defaultTransform;



    /**
     * Get default serializer
     *
     * @return null|SerializerAbstract
     */
    public static function getDefaultSerializer(): ?SerializerAbstract
    {
        if( static::$defaultSerializer && is_string( static::$defaultSerializer ) && class_exists( static::$defaultSerializer ) ) {
            return static::$defaultSerializer ? new static::$defaultSerializer() : newArraySerializer();
        }


        return static::$defaultSerializer ?: newArraySerializer();
    }

    /**
     * Set default serializer
     *
     * @param string|SerializerAbstract|null $defaultSerializer
     */
    public static function setDefaultSerializer($defaultSerializer = null): void
    {
        static::$defaultSerializer = is_string($defaultSerializer) && class_exists( $defaultSerializer) ? new $defaultSerializer() : $defaultSerializer;
    }

    /**
     * Get default transform
     *
     * @return null|callable|TransformerAbstract
     */
    public static function getDefaultTransform(): ?TransformerAbstract
    {
        $transform = static::$defaultTransform ?? null;
        return is_string($transform) && class_exists($transform) ? new $transform : $transform;
    }

    /**
     * Set default transform
     *
     * @param string|null|callable|TransformerAbstract $defaultTransform
     */
    public static function setDefaultTransform($defaultTransform = null): void
    {
        static::$defaultTransform = is_string($defaultTransform) && class_exists( $defaultTransform ) ? new $defaultTransform() : $defaultTransform;
    }

}
