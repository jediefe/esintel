<?php

return [
    'esintel' => [
        'name' => 'ES Intel',
        'icon' => 'fa-user-secret',
        'permission' => 'esintel.view',
        'route_segment' => 'esintel',
        'entries' => [
            [
                'name' => 'Search and View',
                'label' => 'Search and View',
                'plural' => false,
                'icon' => 'fa-search',
                'route' => 'esintel.view',
                'permission' => 'esintel.view',
            ],
            [
                'name' => 'Create Entry',
                'label' => 'Create Entry',
                'plural' => false,
                'icon' => 'fa-user-plus',
                'route' => 'esintel.create',
                'permission' => 'esintel.create',
            ],
            [
                'name' => 'Manage Categories',
                'label' => 'Manage Categories',
                'plural' => false,
                'icon' => 'fa-wrench',
                'route' => 'esintel.categories',
                'permission' => 'superuser'
            ],
        ],
    ],
];