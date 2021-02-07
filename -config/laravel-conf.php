<?php

return [
    // possible values are 'file', 'database'
    'driver' => 'file',

    'autoRouteModels' => [
        'file' => [
            'path' => config_path('autoRouteModels.json'),
        ],
        'database' => [
            'table' => 'autoroutemodels_conf',
        ],
    ],

    'drivers' => [
        'file' => [
            'path' => config_path('crudService.json'),
        ],
        'database' => [
            'table' => 'service_conf',
        ],
    ],
];
