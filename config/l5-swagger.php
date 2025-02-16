<?php

return [
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Resource Booking API',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'annotations' => [
                    base_path('app/Swagger'),
                    base_path('app/Http/Controllers'),
                ],
            ],
        ],
    ],
];
