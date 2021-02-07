<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/12/2019
 * Time: 5:03 PM
 */

namespace Modules\Tools\Traits;


use Illuminate\Support\Collection;

/**
 * Trait HasPaginationDenial
 *
 * @package Modules\Tools\Traits
 */
trait HasPaginationDenial
{
    /**
     * List of method names to deny the pagination when API response.
     *
     * @var array
     */
    protected $deniedPagination = [];

    /**
     * Returns current list of denied actions from pagination.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDeniedPaginationList(): Collection
    {
        return toCollect($this->deniedPagination);
    }
}
