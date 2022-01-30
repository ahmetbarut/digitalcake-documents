<?php

return [
    [
        'title' => "Documents",
        'icon' => 'fa fa-newspaper ',
        'url' => '#',
        'active' => \Request::is('administrator/documents') or \Request::is('administrator/documents/*'),
        'items' => [
            [
                'title' => trans('documents::admin.list_documents'), 'url' => 'administrator/documents/', 'active' => \Request::is('administrator/documents/create')
            ],
            [
                'title' => trans('documents::admin.add_new_document'), 'url' => 'administrator/documents/create', 'active' => \Request::is('administrator/documents/create')
            ],
            [
                'title' => trans('documents::admin.emails'), 'url' => 'administrator/documents/emails', 'active' => \Request::is('administrator/documents/emails')
            ],
        ]
    ]
];
