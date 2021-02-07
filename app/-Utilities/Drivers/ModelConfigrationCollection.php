<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/8/2019
 * Time: 01:10 م
 */

namespace App\Utilities\Drivers;



use App\Traits\HasModelAutoRegister;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nwidart\Modules\Collection;
use Illuminate\Support\Facades\Route;

class ModelConfigrationCollection extends Collection {

#region old
    public static $ainitRegistred = [
    	'Routes'=>[],
    	'Webs'=>[],
    	'Listeners'=>[],
    	'Patterns'=>[],
    ];
	
	private function toRoute_() {
        $registred = collect(ModelConfigrationCollection::$initRegistred['Routes']);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            $registred->put($k, $v);
            Route::model($k, $v);
        });
	    ModelConfigrationCollection::$initRegistred['Routes'] = $registred->toArray();

        return $this;
    }

	private function toWeb_() {
        $registred = collect(ModelConfigrationCollection::$initRegistred['Webs']);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            if(class_exists($v)) {
                if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
                    $v::bootRoute('web');
                    $registred->put($k, ['web'=>$v]);
                }
            }
        });
	    ModelConfigrationCollection::$initRegistred['Webs'] = $registred->toArray();

        return $this;
    }
	
	private function toListener_() {
        $registred = collect(ModelConfigrationCollection::$initRegistred['Listeners']);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            if(class_exists($v)) {
                if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
                    $v::initBootListeners();
                    $registred->put($k, $v);
                }
            }
        });
	    ModelConfigrationCollection::$initRegistred['Listeners'] = $registred->toArray();

        return $this;
    }
	
	private function toPattern_() {
    	d(
		    $this->toArray()
	    );
        $registred = collect(ModelConfigrationCollection::$initRegistred['Patterns']);
        $this->each(function($v, $k) use (&$registred) {
            if($registred->has($k) || $registred->contains($v)) return;

            if(class_exists($v)) {
                if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
                    $v::initBootListeners();
                    $registred->put($k, $v);
                }
            }
        });
	    ModelConfigrationCollection::$initRegistred['Patterns'] = $registred->toArray();

        return $this;
    }
#endregion

    /**
     * Get a base Support collection instance from this collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toBase() {
        return (new self());
    }
    
    public function get($key, $default = null) {
    	$return = Arr::get($this->items, $key, null);
    	if($return) return $return;
		   
	    if ($this->offsetExists($key)) {
		    return $this->items[$key];
	    }
	
	    return value($default);
    }
    
    public function pair(\Closure $callback = null) {
	    $callback = $callback ?: function($k, $v) { return [$k, $v]; };
	    
    	$pairs = new static([]);
	    $this->each(function($v, $k) use (&$registred, &$pairs, $callback) {
		    $pairs->push(
			    $callback($v, $k)
		    );
	    });
	
	    return new static($pairs);
    }
    
	public function __call($method, $parameters) {
    	try {
    	    $return = parent::__call($method, $parameters);
	    } catch (\Exception $exception) {
    		$return = $this->get($method);
    		if(is_array($return) || is_object($return) || is_collection($return))
			    $return = new static($return);
	    }
		return $return;
	}
	
	public function __get($key) {
		try {
			$return = parent::__get($key);
		} catch (\Exception $exception) {
			$return = $this->get($key);
		}
		return $return;
	}
	
	public static function initModelConfigrationCollecrtion($return = null) {
	    // Add a 'AutoModel' macros
	    static::mixin(new ModelConfigrationCollecrtionMacros);
	    
	    return $return;
    }
}
