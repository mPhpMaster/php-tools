<?php

return [
    /*
    | Package settings
    */
    'settings' => [
        'route' => 'niceartisan',
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
];
