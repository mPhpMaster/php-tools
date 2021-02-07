<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/8/2019
 * Time: 01:10 م
 */

namespace App\Utilities\Drivers;


use Garf\LaravelConf\Drivers\AbstractDriver;
use Illuminate\Support\Arr;

class ModelConfigrationSD extends AbstractDriver {

    /**
     * File to save config file.
     *
     * @var null|string
     */
    private $file = null;
    private $app;
    private $colection;

    /**
     * JsonDriver constructor.
     */
    public function __construct($app = null)
    {
        $this->app = $app;
        $this->file = config('laravel-conf.autoRouteModels.file.path', config_path('confSD.json'));

        if (! file_exists($this->file)) {
            $this->config = [];
            $this->persist();
        } else {
            $this->config = json_decode(file_get_contents($this->file), true);
        }

        $this->colection = new ModelConfigrationCollection();
    }

    private function config(...$vars) {
        $_this = $this;
        if(count($vars) < 1)
            return $this->collect($this->config);
        else {
            return $data = $this->collect(
                            $this->collect($this->config)
                                ->reject(function ($v, $k) use ($vars) {
                                    return in_array($k, $vars) === false;
                                })->collapse()
            );
        }
    }

    /**
     * Get config value by key.
     *
     * @param string $key
     * @param bool   $default
     *
     * @return string
     */
    public function get($key, $default = null) {
        $result = Arr::get($this->config, $key, $default);
        return $result;
    }

    /**
     * Store config value by key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        array_set($this->config, $key, $value);
        $this->persist();

        return $this;
    }
    public function add(string $key,string $value)
    {
        return $this->set("enable.{$key}", $value);
    }

    /**
     * Remove key from config.
     *
     * @param string $key
     *
     * @return $this
     */
    public function forget($key)
    {
        array_forget($this->config, $key);
        $this->persist();

        return $this;
    }
    public function remove($key)
    {
        return $this->forget("enable.{$key}");
    }

    /**
     * @return $this
     */
    protected function persist()
    {
        file_put_contents($this->file, json_encode($this->config, JSON_PRETTY_PRINT));

        return $this;
    }

    public function __get($name)
    {
//        if($name == 'all')
            $data = $this->config();
//        else
//            $data = $this->config($name);
        
        return $name == 'all' ? $data->toArray() : $data->get($name, null);
    }

    public function enable($name = null) {
        $data = $this->collect($this->get('disable'));
        if(!$name)
            return $this->collect($this->get('enable'));

        $class = $data->get($name, false);
        if($class) {
            $this->set("enable.{$name}", $class);
            $this->forget("disable.{$name}");
        }

        return $this->collect($this->get('enable'));
    }

    public function disable($name = null) {
        $data = $this->collect($this->get('enable'));
        if(!$name)
            return $this->collect($this->get('disable'));

        $class = $data->get($name, false);
        if($class) {
            $this->set("disable.{$name}", $class);
            $this->forget("enable.{$name}");
        }

        return $this->collect($this->get('disable'));
    }

    public function __call($name, $arguments)
    {
        $data = $this->collect($this->get($name));
        if($arguments) {
        	$data = $data->get(implode(".", $arguments));
        }
        return $data;
    }

    public function collect()
    {
        return new ModelConfigrationCollection(...func_get_args());
    }

}
