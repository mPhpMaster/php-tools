<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use Modules\Tools\Entities\Region;

trait HasRegion
{
    /**
     * get Region model
     *
     * @return mixed
     */
    public function region()
    {
        /** @var $this Model */
        return $this->belongsTo(Region::class);
    }
}
