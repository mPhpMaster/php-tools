<?php

return [
    'name' => 'Artisany',
	
	/*
	| Package settings
	*/
    'settings' => [
	    'route' => 'artisany',
    ],
	
	/*
	| Package middlewares
	*/
    'middleware' => [
    	'support',
    ],
	
	/*
	| Available commands
	*/
    'commands' => [
	
	    /*
		| myth commands
		*/
	    'Myth' => [
		    'myth:install',
		    'myth:make-admin',
		    'myth:role',
		    'make:model-print-helper',
		    'client:make-user',
	    ],
	
	    /*
		| CRUD commands
		*/
	    'CRUD' => [
		    'create:layout',
		    'create:resources',
		    'create:controller',
		    'create:model',
		    'create:form-request',
		    'create:routes',
		    'create:migration',
		    'create:language',
		    'create:mapped-resources',
		    'create:views',
		    'create:index-view',
		    'create:create-view',
		    'create:edit-view',
		    'create:show-view',
		    'create:form-view',
		    'resource-file:from-database',
		    'resource-file:create',
		    'resource-file:append',
		    'resource-file:reduce',
		    'resource-file:delete',
		    'migrate-all',
		    'migrate:rollback-all',
		    'migrate:reset-all',
		    'migrate:refresh-all',
		    'migrate:status-all',
	    ],
	
	    /*
		| Make module commands
		*/
	    'module' => [
		    'module:make',
		    'module:make-command',
		    'module:make-controller',
		    'module:make-event',
		    'module:make-job',
		    'module:make-listener',
		    'module:make-middleware',
		    'module:make-migration',
		    'module:make-model',
		    'module:make-provider',
		    'module:make-request',
		    'module:make-resource',
		    'module:make-seeder',
	    ],
	
	    /*
		| Make commands
		*/
	    'make' => [
		    'make:auth',
		    'make:command',
		    'make:controller',
		    'make:event',
		    'make:exception',
		    'make:factory',
		    'make:job',
		    'make:listener',
		    'make:mail',
		    'make:middleware',
		    'make:migration',
		    'make:model',
		    'make:notification',
		    'make:policy',
		    'make:provider',
		    'make:request',
		    'make:resource',
		    'make:rule',
		    'make:seeder',
		    'make:test',
	    ],
	
	    /*
		| Migrate commands
		*/
	    'migrate' => [
		    'migrate',
		    'migrate:fresh',
		    'migrate:install',
		    'migrate:rollback',
		    'migrate:reset',
		    'migrate:refresh',
		    'migrate:status',
	    ],
	
	    /*
		| Route commands
		*/
	    'route' => [
		    'route:cache',
		    'route:clear',
		    'route:list',
	    ],
	
	    /*
		| Queue commands
		*/
	    'queue' => [
		    'queue:table',
		    'queue:failed',
		    'queue:retry',
		    'queue:forget',
		    'queue:flush',
		    'queue:failed-table',
		    'queue:work',
		    'queue:restart',
		    //'queue:listen',
		    'queue:subscribe',
		    'queue:table',
	    ],
	
	    /*
		| Config commands
		*/
	    'config' => [
		    'config:cache',
		    'config:clear',
	    ],
	
	    /*
		| Cache commands
		*/
	    'cache' => [
		    'cache:clear',
		    'cache:table',
	    ],
	
	    /*
		| Miscellaneous commands
		*/
	    'miscellaneous' => [
		    'app:name',
		    'auth:clear-resets',
		    'clear-compiled',
		    'db:seed',
		    'event:generate',
		    'down',
		    'env',
		    'key:generate',
		    'optimize',
		    'package:discover',
		    'preset',
		    'schedule:run',
		    'serve',
		    'session:table',
		    'storage:link',
		    'vendor:publish',
		    'view:clear',
	    ],
	
	
	    /*
		| AutoRouteModels commands
		*/
	    'AutoRouteModels' => [
		    'routeModels:add',
		    'routeModels:list',
		    'routeModels:remove',
		    'routeModels:status',
	    ],
    ],
	
	/*
	| core commands
	*/
    'coreCommands' =>[
	    'make:auth',
	    'help',
	    'list',
	    'app:name',
	    'clear-compiled',
	    'make:command',
	    'config:cache',
	    'config:clear',
	    'make:console',
	    'event:generate',
	    'make:event',
	    'down',
	    'env',
	    'handler:command',
	    'handler:event',
	    'make:job',
	    'key:generate',
	    'make:listener',
	    'make:model',
	    'optimize',
	    'make:policy',
	    'make:provider',
	    'make:request',
	    'route:cache',
	    'route:clear',
	    'route:list',
	    'serve',
	    'make:test',
	    'tinker',
	    'up',
	    'vendor:publish',
	    'view:clear',
	    'cache:clear',
	    'cache:table',
	    'cache:forget',
	    'schedule:run',
	    'schedule:finish',
	    'migrate',
	    'make:migration',
	    'migrate:fresh',
	    'migrate:install',
	    'migrate:rollback',
	    'migrate:reset',
	    'migrate:refresh',
	    'migrate:status',
	    'db:seed',
	    'make:seeder',
	    'queue:table',
	    'queue:failed',
	    'queue:retry',
	    'queue:forget',
	    'queue:flush',
	    'queue:failed-table',
	    'make:controller',
	    'make:middleware',
	    'session:table',
	    'queue:work',
	    'queue:restart',
	    'queue:listen',
	    'queue:subscribe',
	    'auth:clear-resets',
	    'storage:link',
	    'make:mail',
	    'make:notification',
	    'notifications:table',
	    'make:factory',
	    'make:resource',
	    'make:rule',
	    'preset',
	    'package:discover',
	    'make:exception',
    ],
];
