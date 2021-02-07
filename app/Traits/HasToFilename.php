<?php
/**
 * Created by PhpStorm.
 * User: del
 * Date: 1/8/2019
 * Time: 3:53 PM
 */

namespace Modules\Tools\Traits;


use Carbon\Carbon;

trait HasToFilename
{
    public function toFilename($ext = 'pdf', $time_format = "dmygia")
    {
        $order_number = prefixNumber($this->id);
        $file_time = Carbon::now()->format($time_format);
        return snake_case(class_basename(static::class)) . "-{$order_number}-{$file_time}." . ltrim($ext, '.');
    }
}
