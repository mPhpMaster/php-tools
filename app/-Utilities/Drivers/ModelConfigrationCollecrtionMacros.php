<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14/8/2019
 * Time: 01:10 م
 */

namespace App\Utilities\Drivers;



use App\Traits\HasModelAutoRegister;
use Illuminate\Support\Facades\Route;

class ModelConfigrationCollecrtionMacros {

    public static $initRegistred = [
    	'Routes'=>[],
    	'Webs'=>[],
    	'Listeners'=>[],
    	'Patterns'=>[],
    ];
    
    public function registerRoute() {
    	return function () {
		    $registred = collect(ModelConfigrationCollecrtionMacros::$initRegistred['Routes']);
		    $this->each(function($v, $k) use (&$registred) {
			    if($registred->has($k) || $registred->contains($v)) return;
			
			    $registred->put($k, $v);
			    Route::model($k, $v);
		    });
		    ModelConfigrationCollecrtionMacros::$initRegistred['Routes'] = $registred->toArray();
		
		    return $this;
	    };
	}

	public function registerModelsWeb() {
    	return function () {
		    $registred = collect(ModelConfigrationCollecrtionMacros::$initRegistred['Webs']);
		    $this->each(function($v, $k) use (&$registred) {
			    if($registred->has($k) || $registred->contains($v)) return;
			
			    if(class_exists($v)) {
				    if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
					    $v::bootRoute('web');
					    $registred->put($k, ['web'=>$v]);
				    }
			    }
		    });
		    ModelConfigrationCollecrtionMacros::$initRegistred['Webs'] = $registred->toArray();
		
		    return $this;
    	};
	}

	public function registerModelsListener() {
    	return function () {
		    $registred = collect(ModelConfigrationCollecrtionMacros::$initRegistred['Listeners']);
		    $this->each(function($v, $k) use (&$registred) {
			    if($registred->has($k) || $registred->contains($v)) return;
			
			    if(class_exists($v)) {
				    if(collect((new \ReflectionClass($v))->getTraits())->has(HasModelAutoRegister::class)) {
					    $v::initBootListeners();
					    $registred->put($k, $v);
				    }
			    }
		    });
		    ModelConfigrationCollecrtionMacros::$initRegistred['Listeners'] = $registred->toArray();
		
		    return $this;
	    };
	}
	
	public function registerPattern() {
    	return function () {
		    $registred = collect(ModelConfigrationCollecrtionMacros::$initRegistred['Patterns']);
		    $this->each(function($v, $k) use (&$registred) {
			    if($registred->has($k) || $registred->contains($v)) return;
			
			    $registred->put($k, $v);
			    Route::pattern($k, $v);
		    });
		    ModelConfigrationCollecrtionMacros::$initRegistred['Patterns'] = $registred->toArray();
		
		    return $this;
    	};
	}
//
//	public function enable() {
//    	return function () {
//		    return new static($this->get('enable'));
//    	};
//	}
//
//	public function disable() {
//    	return function () {
//		    return new static($this->get('disable'));
//    	};
//	}

}
