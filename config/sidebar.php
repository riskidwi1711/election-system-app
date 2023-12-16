<?php

return $sidebar = [
    'Home' => [
        [
            'title' => 'Dashboard',
            'icon' => 'ti ti-aperture',
            'url' => 'dashboard',
            'permission' => 'dashboard.view',
        ],
    ],
    'Data' => [
        [
            'title' => 'Calon Presiden',
            'icon' => 'ti ti-user-star',
            'url' => 'capres',
            'permission' => 'capres.view',
        ],
        [
            'title' => 'Saksi',
            'icon' => 'ti ti-users',
            'url' => 'saksi',
            'permission' => 'saksi.view',
        ],
        [
            'title' => 'Suara',
            'icon' => 'ti ti-file-database',
            'url' => 'suara',
            'permission' => 'hasil_suara.view',
        ],
    ]
];
