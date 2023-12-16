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
            'title' => 'Suara Calon',
            'icon' => 'ti ti-file-database',
            'url' => 'suara',
            'permission' => 'hasil_suara.view',
        ],
        [
            'title' => 'Suara Masuk',
            'icon' => 'ti ti-file-database',
            'url' => 'suara_masuk',
            'permission' => 'hasil_suara.view',
        ],
    ],
    'Data Wilayah' => [
        
        [
            'title' => 'Kecamatan',
            'icon' => 'ti ti-map',
            'url' => 'kecamatan',
            'permission' => 'kecamatan.view',
        ],
        [
            'title' => 'Kelurahan',
            'icon' => 'ti ti-map',
            'url' => 'kelurahan',
            'permission' => 'keluarahn.view',
        ]
    ]
];
