<?php

return [
    // Belgelerin depolanacağı model.
    'model' => Digitalcake\Documents\Models\Documents::class,

    // E-posta gönderilirken kullanılacak model.
    'mail_model' => Digitalcake\Documents\Models\DocumentsMail::class,

    // Belgelerin yükleneceği dizin
    'path' => 'uploads/documents',

    // admin tarafındaki sayfalarin şablonu
    'admin' => [
        'views' => [
            'index' => 'package.documents.admin.index',
            'create' => 'package.documents.admin.add',
            'show' => 'documents::show',
            'edit' => 'package.documents.admin.edit',
        ],
    ],

    // Kullanıcı tarafındaki sayfaların şablonu
    'web' => [
        'views' => [
            'create' => 'documents::add_email',
            'download' => null, //'Documents.Views.download',
            'index' => 'package.documents.web.index',
        ]
    ],

    /**
     * Hem web hem admin rotaları
     */
    'routes' => [
        'admin' => [
            'prefix' => 'administrator/documents',
            'middleware' => 'auth.teknoza:administrator',
            'name' => 'administrator.documents.',

            'index' => '/',
            'create' => 'create',
            'store' => 'store',
            'show' => 'show/{documents}',
            'edit' => 'edit/{documents}',
            'update' => 'update/{documents}',
            'destroy' => 'destroy/{documents}',
        ],
        'web' => [
            'prefix' => 'documents',
            'middleware' => [],
            'name' => 'documents.',
            'create' => 'create/{document}',
            'store' => 'store/{document}',
            'download' => 'download/{documents}',
        ],
    ],

    // e-posta modelinde kullanılacak alanlar
    'email_store_fields' => [
        'email'
    ],

    // e-posta da gönderilecek şablon
    'mail' => [
        'template' => 'documents::mail',
    ],
];
