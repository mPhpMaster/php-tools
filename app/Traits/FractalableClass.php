<?php

namespace Modules\Tools\Traits;

use App\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;
use Modules\Shop\Entities\Category;
use Spatie\Fractal\Fractal;
use App\ModelAbstract as Model;

/**
 * trait FractalableClass
 *
 * @method Builder getAsFractal(callable|TransformerAbstract|null $transformer = null)
 *         FractalableClass::getAsFractal()
 *
 * @see     FractalableClass::scopeGetAsFractal()
 *
 * @package Modules\Tools\Traits
 */
trait FractalableClass
{

// region transformers

// region defaults
    /**
     * Get default transform
     *
     * @return null|callable|TransformerAbstract
     */
    abstract public static function getDefaultTransform(): ?TransformerAbstract;

    /**
     * Set default transform0
     *
     * @param null|callable|TransformerAbstract $defaultTransform
     */
    abstract public static function setDefaultTransform($defaultTransform = null): void;

    /**
     * Get default serializer
     *
     * @return null|SerializerAbstract
     */
    abstract public static function getDefaultSerializer(): ?SerializerAbstract;

    /**
     * Set default serializer
     *
     * @param null|SerializerAbstract $defaultSerializer
     */
    abstract public static function setDefaultSerializer($defaultSerializer = null): void;

// endregion defaults

    /**
     * Returns transformed data **as fractal** using fractal.
     *
     * @param null|mixed                        $data
     * @param null|callable|TransformerAbstract $transformer
     * @param null|SerializerAbstract           $serializer
     *
     * @return Fractal
     */
    public static function Fractal($data = null, $transformer = null, $serializer = null): Fractal
    {
        $data = $data ?: null;
        $transformer = $transformer ?: static::getDefaultTransform();
        $serializer = $serializer ?: static::getDefaultSerializer();

        if( isModel($data) ) {
            $result = [
                'result'=>$data,
                'inputType'=>null
            ];
        } else {
            $result = self::transformInput($data);
        }

        $data = $result['result'];
        $inputType = $result['inputType'];
        return $fractal = fractal( $data, $transformer, iif($inputType === 'pages', null, $serializer ));
    }


    /**
     * Returns transformed data **as array** using fractal.
     *
     * @param null|mixed                        $data
     * @param null|callable|TransformerAbstract $transformer
     * @param null|SerializerAbstract           $serializer
     *
     * @return array
     */
    public function toFractal($data = null, $transformer = null, $serializer = null): array
    {
        /** @var Builder $data */
        $data = $data ?: $this;

//        if(isModel($data)) {
//            $data = modelToQuery($data);
//        }

        $fractal = static::Fractal(
            $data,
            test($transformer, static::getDefaultTransform()),
            test($serializer, static::getDefaultSerializer())
        );

        /** @var Fractal $fractal */
        $finalData = iif(
            $fractal instanceof Arrayable,
            function () use ($fractal) { return $fractal->toArray(); },
            function () use ($fractal) { return is_array($fractal) ? $fractal : toCollect($fractal)->toArray(); }
        ) ?: [];

        return $finalData;
    }

// endregion transformers

    /**
     * self::getAsFractal()
     * Scope for get and call toFractal().
     *
     * @param Builder                           $query
     * @param null|callable|TransformerAbstract $transformer
     *
     * @return array
     */
    public function scopeGetAsFractal($query, $transformer = null): array
    {
        return $this->toFractal( $query, $transformer ?? static::getDefaultTransform());
    }

    /**
     * Transform From any To [->get()|->paginate()]
     *
     * @param mixed $query
     *
     * @return [ resutl=>Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator, inputType => collection|pages]
     */
    public static function transformInput($query)
    {
        $isBuilder = $freeToPaginate = $canPaginate = $needToPaginate = $isDataPaginated = false;
        $transformTo = null; // Pages | Collection

//        $query = ItemContainer::make($query);
        /**
         * Check if data accepts to paginate
         *
         * @var $freeToPaginate bool is data accept pagination ?
         */
        $freeToPaginate = !self::isDenied();
        $canPaginate = getRequestedPage();
        $isDataPaginated = !($isBuilder = isBuilder($query)) && isPaginated($query);

        if ( $isDataPaginated ) {
            $query = dePaginate($query);
            $isDataPaginated = false;
        }

        /**
         * Check if data need to paginate
         *
         * @var $isDataPaginated bool is data already paginated ?
         */
        $isBuilder = isBuilder($query);
        if ( !$freeToPaginate || !$canPaginate ) {
            $transformTo = "collection"; // Pages | Collection
        } else if ( $freeToPaginate && $canPaginate ) {
            $transformTo = "pages"; // Pages | Collection
        } else if ( ($freeToPaginate && !$canPaginate) || (!$freeToPaginate && $canPaginate) ) {
            $transformTo = "collection"; // Pages | Collection
        }

//        dE(toCollectOrModel($query), $transformTo, $query );
        // Builder | Collection
        /** @var Collection|Builder|\Illuminate\Contracts\Pagination\LengthAwarePaginator $query */
        if ( $transformTo === 'pages' ) {
            $query = $isBuilder ? $query : (toCollectWithModel($query));
        } else {
            $query = $isBuilder ? $query : (toCollectOrModel($query));
        }

        if ( !($isDataPaginated = isPaginated($query)) ) {
            if ( $transformTo === 'pages' ) {
//                dE( get_class($query) );
//                $query = is_collection($query) ? $query : $query->get();
                $query = $query->paginate(config("tools.fractalable.results_per_page", 25));
                /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $query */
            } else if ( $transformTo === 'collection' ) {
                if ( !($query instanceof Model) && is_collection($query) ) {
                    $query = $query->all();
                } else if ( !($query instanceof Model) ) {
                    $query = $query->get();
                }
                /** @var Collection|Model but not LengthAwarePaginator $query */
            }
        }

//        return getRequestedPage()
//            ? $query->paginate(25)
//            : $query->get();
        return [
            "result" => $query,
            "inputType" => $transformTo
        ];
    }

    /**
     * Check if user denied to paginate.
     *
     * @return bool
     */
    public static function isDenied()
    {
        /**
         * Check if data accepts to paginate
         *
         * @var $expr bool is data accept pagination ?
         */
        $expr = true;
        if ( $currentController = currentController() ) {
            if (
                method_exists($currentController, 'canPaginate') &&
                !$currentController->canPaginate(currentActionName())
            ) {
                $expr = false;
            }
        }
        return !$expr;
    }
}
