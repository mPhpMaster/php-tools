<?php

namespace Modules\Cfg;

use Modules\Cfg\Drivers\DatabaseDriver;
use Modules\Cfg\Drivers\FileDriver;
use Illuminate\Support\Manager;

/**
 * Class ConfManager.
 */
class ConfManager extends Manager
{
    /**
     * Create new instance of ConfManager class.
     *
     * @param \Illuminate\Foundation\Application $driver
     */
    public function __construct($driver)
    {
        parent::__construct($driver);
    }

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return FileDriver
     */
    protected function createFileDriver()
    {
        $config = $this->app['config']['cfg.drivers.file'];

        return $this->buildProvider(
            FileDriver::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return FIleDriver
     */
    protected function createDatabaseDriver()
    {
        $config = $this->app['config']['cfg.drivers.database'];

        return $this->buildProvider(
            DatabaseDriver::class, $config
        );
    }

    /**
     * Build configuration provider instance.
     *
     * @param  string $provider
     * @param  array  $config
     *
     * @return Drivers\AbstractDriver
     */
    public function buildProvider($provider, $config)
    {
        return new $provider($config);
    }

    /**
     * Get the default driver name.
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['cfg.driver'];
//        return \Garf\LaravelConf\Drivers\JsonDriver::class;
    }
}
