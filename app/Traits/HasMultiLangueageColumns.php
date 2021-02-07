<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

/**
 * Trait HasMultiLangueageColumns
 * SEE LINE 17 & 30
 *
 * @uses \Illuminate\Database\Eloquent\Concerns\HasAttributes
 *
 * @package Modules\Tools\Traits
 */
trait HasMultiLangueageColumns
{
    /*
     * USE THIS IN MODEL
     */
    /*
    use HasMultiLangueageColumns {
        HasMultiLangueageColumns::__construct as public __constructHasMultiLangueageColumns;
    }*/

    /**
     * Returns array of columns name
     *
     * @return array
     */
    public function getMultiLanguageColumns(): array
    {
        return [
            'name',
        ];
    }

    /**
     * Check wether $column is multi language or not
     *
     * @param string $column Column name
     *
     * @return bool true|false
     */
    public function hasMultiLanguageColumns(string $column): bool
    {
        return in_array($column, $this->getMultiLanguageColumns()) === true;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public function __construct()
    {
        $this->appends = array_merge([], $this->getMultiLanguageColumns(), $this->appends);
        $langs = collect(config('language.allowed'));

        collect($this->getMultiLanguageColumns())
            ->each(function ($columnName) use ($langs) {
                $MLColumns = $langs->map(function ($langName) use ($columnName) {
                    return "{$columnName}_{$langName}";
                })->toArray();

                $this->fillable = collect(array_merge([], $MLColumns, $this->fillable))->unique()->toArray();
            });

        if (method_exists(get_parent_class(), "__construct")) {
            parent::__construct(...func_get_args());
        }
    }

    /**
     * Columns getter
     *
     * @param $key
     *
     * @return null|string
     */
    public function __get($key)
    {
        if ($this->hasMultiLanguageColumns($key)) {
            return isset($this->attributes[tool_title_locale($key)])
                ? ucfirst($this->attributes[tool_title_locale($key)])
                : null;
        } else {
            return parent::getAttribute($key);
        }
    }

    /**
     * Columns setter
     *
     * @param string      $key   Column name
     * @param string|null $value Column value
     */
    public function __set($key, $value)
    {
        if ($this->hasMultiLanguageColumns($key)) {
            parent::setAttribute(tool_title_locale($key), $value);
        } else {
            parent::setAttribute($key, $value);
        }
    }


    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function hasGetMutator($key)
    {
        if ($this->hasMultiLanguageColumns($key)) {
            return true;
        }

        return parent::hasGetMutator($key);
    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        if ($this->hasMultiLanguageColumns($key)) {
            return $this->__get($key, $value);
        }

        return parent::mutateAttribute($key, $value);
    }

}
