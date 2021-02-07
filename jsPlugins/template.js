;(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
		typeof define === 'function' && define.amd ? define(factory) :
			global.plugin = factory()
}(this, (function () {
	'use strict';
	
	
	var plugin = function PLUGIN(x) {
		let $this;
		
		if(this instanceof PLUGIN) {
			$this = this;
			$this.time = (new Date()).getTime();
			$this.data = x;
			
		} else {
			$this = new PLUGIN(...arguments);
		}
		
		return $this;
	};
	
	let props = {
		plugin: '1.0.0',
		init: plugin,
	};
	
	plugin.prototype = props;
	
	return plugin;
	
})));