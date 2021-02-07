<?php

namespace Modules\Tools\Traits;

use Illuminate\Contracts\Support\Arrayable;
use \App\ModelAbstract as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

/**
 * Trait BaseApiTrait
 *
 * @package Modules\Tools\Traits
 */
trait BaseApiTrait
{
    use FractalableClass;
    use DefaultsForFractalables;

    /**
     * @var null|SerializerAbstract $defaultSerializer
     */
//    protected static $defaultSerializer;
    /**
     * @var null|callable|TransformerAbstract $defaultTransform
     */
//    protected static $defaultTransform;

// region controllers

    /**
     * Returns Validator Rules.
     *
     * ---
     *      return example:
     *          [
     *              "name_ar"           => [ "nullable" ],
     *              "name_en"           => [ "nullable" ],
     *              "status"            => [ "nullable" ]
     *          ];
     *
     * @return array|null
     */
    abstract public static function getRules(): ?array;

    /**
     * Returns **Class Name** of Controller **Model** Class.
     *
     * @return string|null
     */
    abstract public static function getModelName(): ?string;

    /**
     * Returns **New Class Instance** of Controller **Model**.
     *
     * @return Model|null
     */
    public static function getModelInstance(): ?Model
    {
        return ( $class = static::getModelName() ) ? new $class : null;
    }
// endregion controllers

// region Validators

// region getRequestData

    /**
     * Returns Model table name.
     *
     * @param null|string $model Model class.
     *
     * @return null|string
     */
    public static function getTable(string $model = null): ?string
    {
        return getTable( $model ?: static::getModelName() );
    }

    /**
     * Returns Model Fillable.
     *
     * @param null|string $model Model class.
     *
     * @return null|array
     */
    public static function getFillable(string $model = null): ?array
    {
        return getFillable( $model ?: static::getModelName() );
    }

    /**
     * #API
     * Returns model data.
     *
     * @param Request                                  $request
     * @param Model|null $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    abstract public function index(Request $request, Model $model = null): \Illuminate\Http\JsonResponse;

    /**
     * #API
     * Update model data.
     *
     * @param Request                             $request
     * @param Model $model
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    abstract public function update(Request $request, Model $model);
// endregion getRequestData

    /**
     * #API
     * Delete model.
     *
     * @param Request                             $request
     * @param Model $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    abstract public function destroy(Request $request, Model $model): \Illuminate\Http\JsonResponse;

    /**
     * Returns data from request as model fillable.
     *
     * @param Request|null $request
     *
     * @return array
     */
    public function getRequestDataAsFillable(Request $request = null): array
    {
        return $this->getRequestData( self::getFillable(), $request );
    }

    /**
     * Returns data from request as $only.
     *
     * @param array|null   $only
     * @param Request|null $request
     *
     * @return array
     */
    public function getRequestData(array $only = null, Request $request = null): array
    {
        /** @var Request $_request */
        $_request = $request ?: request();

        return $only ? $_request->only( $only ) : $_request->all();
    }

    /**
     * Run the validator's rules against its data.
     *
     * **Unimplemented Params**:
     *      array $messages
     *      array $customAttributes
     *
     * @param array|null $data  [default: {@link getRequestDataAsRules()}]
     * @param array|null $rules [default: {@link getRules()}]
     *
     * @return array
     */
    protected function validate(array $data = null, array $rules = null): array
    {
        /** @var Arrayable $rules */
        $rules = $rules && $rules instanceof Arrayable ? $rules->toArray() : (is_array( $rules) ? $rules : static::getRules());
        $data = $data ?: $this->getRequestDataAsRules();

        $return = Validator::make( $data, collect( $rules )->toArray() )->validate();

        return collect( $return )->only( toCollect( $rules )->keys() )->toArray();
    }

    /**
     * Returns data from request as Array keys of {@link getRules() getRules()}.
     *
     * @param Request|null $request
     *
     * @return array
     */
    public function getRequestDataAsRules(Request $request = null): array
    {
        return $this->getRequestData( array_keys( static::getRules() ), $request );
    }
// endregion Validators

// region models

    /**
     * Run the validator's rules against its data.
     *
     * **Unimplemented Params**:
     *      array $messages
     *      array $customAttributes
     *
     * @return array
     */
    protected function validateByCurrentRules(): array
    {
        /** @var Arrayable $rules */
        $rules = isArrayable( $rules = self::getCurrentRules() ) ? $rules->toArray() : $rules;
        $data = $this->getRequestData( array_keys( self::getCurrentRules() ) );

        return $this->validate( $data, $rules );
    }

    /**
     * Returns {@link getRules()}[*current Action Method name*]
     *
     * @param string|null $mode
     *
     * @return array|null
     */
    public static function getCurrentRules(string $mode = null): ?array
    {
        $rules = static::getRules();
        $mode = $mode ?: currentRoute()->getActionMethod();

        return $mode ? ( $rules[$mode] ?? null ) : $rules;
    }

    /**
     * Returns the gavin **$mode** or **current Action Method name**
     *
     * @param string|null $mode update|create|..
     * @deprecated not used
     * @return string
     */
    public static function getCurrentMode(string $mode = null): string
    {
        return $mode ?: currentRoute()->getActionMethod();
    }

    /**
     * Returns data from request as Array keys of {@link getCurrentRules() getCurrentRules()}.
     *
     * @param Request|null $request
     * @deprecated not used
     * @return array
     */
    public function getRequestDataAsCurrentRules(Request $request = null): array
    {
        return $this->getRequestData( array_keys( self::getCurrentRules() ), $request );
    }
// endregion models

}
