<?php

return [
    'name' => 'Cfg',
	
    // possible values are 'file', 'database'
    'driver' => 'file',

    'FileDriverTwo' => [
        'file' => [
            'path' => module_path('Cfg') . "\Config\FileDriverTwo.json",
        ],
    ],
    'cfg' => [
        'file' => [
            'path' => module_path('Cfg') . "\Config\cfg.json",
        ],
        'database' => [
            'table' => 'cfg',
        ],
    ],
    'drivers' => [
        'all' => [
            'Modules\\Cfg\\Drivers\\FileDriverTwo',
        ],
        'file' => [
            'path' => module_path('Cfg') . "\Config\config.json",
        ],
        'database' => [
            'table' => 'cfg',
        ],
    ],
];
