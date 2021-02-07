<?php

namespace {@ filter_namespace @};

use EloquentFilter\ModelFilter;

class {@ filter_name @} extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relatedModel => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($query)
    {
        return $this->whereLike(attrLocaleName(), $query);
    }

}
