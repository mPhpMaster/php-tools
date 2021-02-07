<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/8/2019
 * Time: 01:10 م
 */

namespace App\Utilities\Drivers;



use App\Traits\HasModelAutoRegister;
use Nwidart\Modules\Collection;
use Illuminate\Support\Facades\Route;

class ModelConfigrationCollecrtion extends Collection {

    public static $registredRoutes = [];
    public static $registredWebs = [];
    public static $registredListeners = [];

    public function toRoute() {
        $registred = collect(self::$registredRoutes);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            $registred->put($k, $v);
            Route::model($k, $v);
        });
        self::$registredRoutes = $registred->toArray();

        return $this;
    }

    public function toWeb() {
        $registred = collect(self::$registredWebs);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            if(class_exists($v)) {
                if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
                    $v::bootRoute('web');
                    $registred->put($k, ['web'=>$v]);
                }
            }
        });
        self::$registredWebs = $registred->toArray();

        return $this;
    }

    public function toListener() {
        $registred = collect(self::$registredListeners);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            if(class_exists($v)) {
                if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
                    $v::initBootListeners();
                    $registred->put($k, $v);
                }
            }
        });
        self::$registredListeners = $registred->toArray();

        return $this;
    }

    /**
     * Get a base Support collection instance from this collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toBase() {
        return (new self());
    }

}
