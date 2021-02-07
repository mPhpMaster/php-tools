<?php


return [
    'name'=>'{@ model_name @}',

    'menus'=>[
        'test1' => [
            'title' => ['{@ lang_name @}.menu'],
            'icon' => 'fa fa-heart',
            'active' => [{@ model_class @}::routePath('')],
            'order' => 1,
            'status' => true,
            'permissions' => {@ model_class @}::PermissionName('*'),
            'group' => ['global'],

            'subs' => [
                'test2' => [
                    'route' => {@ model_class @}::routePath('index'),
                    'title' => ['{@ lang_name @}.sub_menu', 1],
                    'icon' => 'fa fa-angle-double-right',
                    'order' => 1,
                    'permissions' => [{@ model_class @}::PermissionName('read')],
                    'active' => [{@ model_class @}::routePath('show')],
                    'status' => true,
                    'group' => ['global'],
                ],
                'test3' => [
                    'route' => {@ model_class @}::routePath('create'),
                    'title' => ['{@ lang_name @}.sub_add', 1],
                    'icon' => 'fa fa-pen',
                    'order' => 1,
                    'permissions' => [{@ model_class @}::PermissionName('create')],
                    'active' => [{@ model_class @}::routePath('edit')],
                    'status' => true,
                    'group' => ['global'],
                ],
            ]
        ],

    ]
];