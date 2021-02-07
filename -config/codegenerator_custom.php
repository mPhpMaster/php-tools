<?php

return [

    /*
|--------------------------------------------------------------------------
| CodeGenerator config overrides
|--------------------------------------------------------------------------
|
| It is a good idea to sperate your configuration form the code-generator's
| own configuration. This way you won't lose any settings/preference
| you have when upgrading to a new version of the package.
|
| Additionally, you will always know any the configuration difference between
| the default config than your own.
|
| To override the setting that is found in the codegenerator.php file, you'll
| need to create identical key here with a different value
|
| IMPORTANT: When overriding an option that is an array, the configurations
| are merged together using php's array_merge() function. This means that
| any option that you list here will take presence during a conflict in keys.
|
| EXAMPLE: The following addition to this file, will add another entry in
| the common_definitions collection
|
|   'common_definitions' =>
|   [
|       [
|           'match' => '*_at',
|           'set' => [
|               'css-class' => 'datetime-picker',
|           ],
|       ],
|   ],
|
 */
    'template' => 'tst',
    'organize_migrations' => true,

    /*
    |--------------------------------------------------------------------------
    | The default path of where the json resource-files are located.
    |--------------------------------------------------------------------------
    |
    | In this path, you can create json file to import the resources from.
    |
     */
    'resource_file_path' => 'resources/laravel-code-generator/sources',

    /*
    |--------------------------------------------------------------------------
    | The default path for any system used file
    |--------------------------------------------------------------------------
    |
     */
    'system_files_path' => 'resources/laravel-code-generator/system',

    /*
    |--------------------------------------------------------------------------
    | The default path of where the migrations will be generated into.
    |--------------------------------------------------------------------------
    |
     */
    'migrations_path' => 'database/migrations',

    /*
    |--------------------------------------------------------------------------
    | The default path of where the controllers will be generated into.
    |--------------------------------------------------------------------------
    |
     */
    'form_requests_path' => 'Http/Requests/Crud',

    /*
    |--------------------------------------------------------------------------
    | The default path of where the controllers will be generated into.
    |--------------------------------------------------------------------------
    |
     */
    'controllers_path' => 'Http/Controllers/Crud',
    'crud_routes_path' => 'routes/crud',

    /*
    |--------------------------------------------------------------------------
    | The default path of where the models will be generated into.
    |--------------------------------------------------------------------------
    |
     */
    'models_path' => 'Models/Crud',

    /*
    |--------------------------------------------------------------------------
    | The default path of where the languages will be generated into.
    |--------------------------------------------------------------------------
    |
     */
    'languages_path' => 'resources/lang',

    /*
    |--------------------------------------------------------------------------
    | A string to postfix the controller name with.
    |--------------------------------------------------------------------------
    |
    | If you don't like to post fix the controller with "Controller" you can
    | set this value to an empty string. Or, you can set it to any other value.
    |
     */
    'controller_name_postfix' => 'Controller',

    /*
    |--------------------------------------------------------------------------
    | A string to postfix the form-request name with.
    |--------------------------------------------------------------------------
    |
    | If you don't like to post fix the form-request with "FormRequest" you can
    | set this value to an empty string. Or, you can set it to any other value.
    |
     */
    'form_request_name_postfix' => 'FormRequest',

    /*
    |--------------------------------------------------------------------------
    | Key phrases that are will be used to determine if a field should have a relation.
    |--------------------------------------------------------------------------
    |
    | When creating resources from existing database, the codegenerator scans
    | the field's name for a mattching pattern. When found, these field are considered
    | foreign keys even when the database does not have a foreign constraints.
    | Here you can specify patterns to help the generator understand your
    | database naming convension.
    |
     */
    'common_key_patterns' => [
        '*_id',
        '*_by',
    ],

    /*
    |--------------------------------------------------------------------------
    | Patterns to use to pre-set field's properties.
    |--------------------------------------------------------------------------
    |
    | To make constructing fields easy, the code-generator scans the field's name
    | for a matching pattern. If the name matches any of these patterns, the
    | field's properties will be set accordingly. Defining pattern will save
    | you from having to re-define the properties for common fields.
    |
     */
    'common_definitions' => [
        [
            'match' => '*',
            'set' => [
                // You may use any of the field templates to create the label
                'labels' => '',
                'placeholder' => '',
            ],
        ],
        [
            'match' => 'id',
            'set' => [
                'is-on-form' => false,
                'is-on-index' => false,
                'is-on-show' => false,
                'html-type' => 'hidden',
                'data-type' => 'integer',
                'is-primary' => true,
                'is-auto-increment' => true,
                'is-nullable' => false,
                'is-unsigned' => true,
            ],
        ],
        [
            'match' => ['title', 'name', 'label', 'subject', 'head*'],
            'set' => [
                'is-nullable' => false,
                'data-type' => 'string',
                'data-type-params' => [255],
            ],
        ],
        [
            'match' => ['*count*', 'total*', '*number*', '*age*'],
            'set' => [
                'html-type' => 'number',
            ],
        ],
        [
            'match' => ['description*', 'detail*', 'note*', 'message*'],
            'set' => [
                'is-on-index' => false,
                'html-type' => 'textarea',
                'data-type-params' => [1000],
            ],
        ],
        [
            'match' => ['picture', 'file', 'photo', 'avatar'],
            'set' => [
                'is-on-index' => false,
                'html-type' => 'file',
            ],
        ],
        [
            'match' => ['*password*'],
            'set' => [
                'html-type' => 'password',
            ],
        ],
        [
            'match' => ['*email*'],
            'set' => [
                'html-type' => 'email',
            ],
        ],
        [
            'match' => ['*_id', '*_by'],
            'set' => [
                'data-type' => 'integer',
                'html-type' => 'select',
                'is-nullable' => false,
                'is-unsigned' => true,
                'is-index' => true,
            ],
        ],
        [
            'match' => ['*_at'],
            'set' => [
                'data-type' => 'datetime',
            ],
        ],
        [
            'match' => ['created_at', 'updated_at', 'deleted_at'],
            'set' => [
                'data-type' => 'datetime',
                'is-on-form' => false,
                'is-on-index' => false,
                'is-on-show' => true,
            ],
        ],
        [
            'match' => ['*_date', 'date_*'],
            'set' => [
                'data-type' => 'date',
                'date-format' => 'j/n/Y',
            ],
        ],
        [
            'match' => ['is_*', 'has_*'],
            'set' => [
                'data-type' => 'boolean',
                'html-type' => 'checkbox',
                'is-nullable' => false,
                'options' => ["No", "Yes"],
            ],
        ],
        [
            'match' => 'created_by',
            'set' => [
                'title' => 'Creator',
                'data-type' => 'integer',
                'foreign-relation' => [
                    'name' => 'creator',
                    'type' => 'belongsTo',
                    'params' => [
                        'App\\Models\\Auth\\User',
                        'created_by',
                    ],
                    'field' => 'name',
                ],
                'on-store' => 'Illuminate\Support\Facades\Auth::Id();',
            ],
        ],
        [
            'match' => ['updated_by', 'modified_by'],
            'set' => [
                'title' => 'Updater',
                'data-type' => 'integer',
                'foreign-relation' => [
                    'name' => 'updater',
                    'type' => 'belongsTo',
                    'params' => [
                        'App\\Models\\Auth\\User',
                        'updated_by',
                    ],
                    'field' => 'name',
                ],
                'on-update' => 'Illuminate\Support\Facades\Auth::Id();',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Plural vs singular naming conventions.
    |--------------------------------------------------------------------------
    |
     */
    'plural_names_for' => [
        'controller-name' => true,
        'request-form-name' => true,
        'route-group' => true,
        'language-file-name' => true,
        'resource-file-name' => true,
        'table-name' => true,
    ],
];
