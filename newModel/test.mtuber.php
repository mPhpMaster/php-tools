<?php


return [
    'name'=>'Mtuber',

    'top_dir'=>'test',

    'namespaces' => [
        'controller'  => null,
        'model'  => null,
        'request'  => null,
        'transformer'  => null,
        'filter'  => null,
        'listener'  => null,
    ],

    'tokens' => [
        'controller_name' => "Mtubers",
        'model_name' => "Mtuber",
        'request_name' => "MtuberRequest",
        'filter_name' => "MtuberFilter",
        'transformer_name' => "Mtuber",
        'listener_name' => "AdminMenu",

        'config_name' => "mtuber",
        'lang_name' => "mtuber",
        'view_name' => "mtubers",
        'table_name' => "mtubers",
        'migration_name' => date("Y_m_d") . "_000000_create_mtubers_table",
        'autoRouteModel_name' => "mtuber",
    ],

    'paths'=>[
            'model'=>"App\\Models\\test\\file",
            'config'=>"config\\test\\file",
            'listener'=>"App\\Listeners\\test\\file",
            'controller'=>"App\\Http\\Controllers\\test\\file",
            'filter'=>"App\\Filters\\test\\file",
            'transformer'=>"App\\Transformers\\test\\file",
            'request'=>"App\\Http\\Requests\\test\\file",
            'migration'=>"database\\migrations\\test\\file",
            'lang'=>[
                    "ar" => "resources\\lang\\ar\\test\\file",
                    "en" => "resources\\lang\\en\\test\\file",
            ],
            'view'=>[
                    "index" => "resources\\views\\test\\mtubers\\file",
                    "create" => "resources\\views\\test\\mtubers\\file",
                    "edit" => "resources\\views\\test\\mtubers\\file",
                    "show" => "resources\\views\\test\\mtubers\\file",
                    "form" => "resources\\views\\test\\mtubers\\file",
            ],
    ],

    'stubs'=>[
            'model'=>"App\\Models\\Stuber",
            'config'=>"config\\Stuber",
            'listener'=>"App\\Listeners\\Stuber",
            'controller'=>"App\\Http\\Controllers\\Stubers",
            'filter'=>"App\\Filters\\StuberFilter",
            'transformer'=>"App\\Transformers\\Stuber",
            'request'=>"App\\Http\\Requests\\StuberRequest",
            'migration'=>"database\\migrations\\2019_08_17_000000_create_stubers_table",
            'lang'=>[
                    "ar" => "resources\\lang\\ar\\stuber",
                    "en" => "resources\\lang\\en\\stuber",
            ],
            'view'=>[
                    "index" => "resources\\views\\stubers\\index.blade",
                    "create" => "resources\\views\\stubers\\create.blade",
                    "edit" => "resources\\views\\stubers\\edit.blade",
                    "show" => "resources\\views\\stubers\\show.blade",
                    "form" => "resources\\views\\stubers\\form.blade",
            ],
    ],

    'autoRouteModel' => true,

];