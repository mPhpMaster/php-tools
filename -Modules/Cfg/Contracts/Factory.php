<?php

namespace Modules\Cfg\Contracts;

interface Factory
{
    /**
     * Get configuration storage provider implementation.
     *
     * @param  string  $driver
     * @return \Garf\LaravelConf\Contracts\ConfContract
     */
    public function driver($driver = null);
}
