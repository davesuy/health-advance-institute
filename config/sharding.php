<?php

return [
    'shards' => [
        'shard1' => [
            'host' => env('DB_SHARD1_HOST', '127.0.0.1'),
            'database' => env('DB_SHARD1_DATABASE', 'shard1'),
            'username' => env('DB_SHARD1_USERNAME', 'root'),
            'password' => env('DB_SHARD1_PASSWORD', ''),
        ],
        'shard2' => [
            'host' => env('DB_SHARD2_HOST', '127.0.0.1'),
            'database' => env('DB_SHARD2_DATABASE', 'shard2'),
            'username' => env('DB_SHARD2_USERNAME', 'root'),
            'password' => env('DB_SHARD2_PASSWORD', ''),
        ],
        'hai' => [
            'host' => env('DB_HAI_HOST', '127.0.0.1'),
            'port' => env('DB_HAI_PORT', '3306'),
            'database' => env('DB_HAI_DATABASE', 'hai'),
            'username' => env('DB_HAI_USERNAME', 'root'),
            'password' => env('DB_HAI_PASSWORD', ''),
        ],
        // Add more shards as needed
    ],
];
