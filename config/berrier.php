<?php

return [
    'user_model' => '\Wislem\Berrier\Models\User',
    'permissions' => [
        'modules' => [
            'pages' => 'mod:0',
            'posts' => 'mod:1',
            'categories' => 'mod:0',
            'settings' => 'mod:0',
            'users' => 'mod:0',
            'blocks' => 'mod:1'
        ]
    ],
    'theme' => [
        'name' => 'default',
        'widget_positions' => [
            'logo' => 'Logo'
        ]
    ]
];
