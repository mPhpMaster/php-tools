;(function ($global, $root) {
	$root = $root || (()=>
		typeof $ !== 'undefined' && typeof $['fn'] !== 'undefined' ? $.fn :
			typeof jQuery !== 'undefined' && typeof jQuery['fn'] !== 'undefined' ? jQuery.fn :
				typeof _z !== 'undefined' && typeof _z['$'] !== 'undefined' ? _z.$ :
					typeof global !== 'undefined' ? global : (window || {}));
	
	let wrapFactory = ((x) => (typeof x) === 'function' ? {[x.name]: x} : x),
		parseFactory = function (factory) {
			factory = [...arguments];
			return typeof factory[0] === "function" ? factory[0].call(this, ...factory.slice(1)) : factory[0];
		};
	
	$global['factory'] = $global['factory'] ||
		(function (root, factory) {
			(arguments.length === 1) && (factory = root) && (root = $root());
			(typeof root === 'function') && (root = root());
			root = root || $global;
			let fnPlugin;
			
			if(fnPlugin = wrapFactory( parseFactory.call($global, factory, root) )) {
				if(typeof exports === 'object' && typeof module !== 'undefined') {
					module.exports = fnPlugin;
				} else if(typeof define === 'function' && define.amd) {
					define(fnPlugin);
					// define([], fnPlugin);
				} else {
					for (let plugin in fnPlugin)
						root[plugin] = fnPlugin[plugin];
				}
			}
		});
	
})(this);