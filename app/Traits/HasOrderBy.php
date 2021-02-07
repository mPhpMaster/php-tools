<?php
/**
 * Created by PhpStorm.
 * User: A.Fayez
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;

use Illuminate\Database\Eloquent\Builder;


trait HasOrderBy
{

    /**
     * The "booting" method of the model.
     *
     * Order By "order_by"
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderBy', function (Builder $builder) {
            $type = "oldest";
            property_exists(static::class, 'orderBy') && (
            $type = self::$orderBy);

            if ($type == "oldest") {
                $builder->oldest('order_by');
            } else if ($type == "latest") {
                $builder->latest('order_by');
            } else
                $builder->oldest('order_by');
        });
    }
}
