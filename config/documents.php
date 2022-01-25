<?php

return [
    'model' => Digitalcake\Documents\Models\Documents::class,
    'mail_model' => Digitalcake\Documents\Models\DocumentsMail::class,

    'path' => 'uploads/documents',

    'routes' => [
        'admin' => [
            'prefix' => 'administrator/documents',
            'middleware' => ['auth'],
            'name' => 'administrator.',
            'index' => '/',
            'create' => 'create',
            'store' => 'store',
            'show' => 'show/{documents}',
            'update' => 'update/{documents}',

            'views' => [
                'index' => 'document::index',
                'create' => 'document::upload',
                'show' => 'document::show',
                'edit' => 'document::edit',
            ],
        ],
        'web' => [
            'prefix' => 'documents',
            'middleware' => [],
            'name' => 'documents.',
            'create' => 'create/{document}',
            'store' => 'store/{document}',
            'download' => 'download/{documents}',

            'views' => [
                'create' => 'document::add_email',
                'download' => null //'Documents.Views.download',
            ]
        ],
    ],
    
    // 'table' => 'documents',

    // 'migration_path' => 'database/migrations',

    'email_store_fields' => [
        'email'
    ],

    'mail' => [
        'template' => 'Documents.Views.mail',
    ],
];