<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use Modules\Tools\Entities\Region;

trait HasRegions
{
    /**
     * get Regions model
     *
     * @return mixed
     */
    public function regions()
    {
        /** @var $this Model */
        return $this->hasMany(Region::class);
    }
}
