<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use \App\ModelAbstract as Model;

trait ModelsMoreAccess
{
    public function isEmpty()
    {
        /** @var Model $newThis */
        $newThis = $this->newInstance([]);

        /** @var Model $this */
        return $this->is($newThis) &&
            count(array_diff_assoc($this->toArray(), $newThis->toArray())) == 0;
    }
}
