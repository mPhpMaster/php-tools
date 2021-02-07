<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


trait HasDataArray
{

    public function dataArray(): array
    {
        $d = parent::toArray();
        if ($this->status_label)
            $d['status'] = $this->status_label;
        return $d;
    }

    public function failDataArray(): array
    {
        $keys = array_flip($this->getFillable());

        $d = parent::toArray();

        if ($this->status_label)
            $d['status'] = $this->status_label;
        foreach ($d as $k => $v) {
            if (!array_key_exists($k, $keys)) {
                unset($d[$k]);
            }
        }
        return $d;
    }
}
