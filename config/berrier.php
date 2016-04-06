<?php
// 0:Member, 1:Moderator, 2:Administrator
return [
    'user_model' => '\App\User',
    'permissions' => [
        'modules' => [
            'pages' => [1,2],
            'posts' => [1,2],
            'categories' => [2],
            'settings' => [2],
            'users' => [2],
            'blocks' => [1,2]
        ]
    ],
    'theme' => [
        'name' => 'default',
        'widget_positions' => [
            'logo' => 'Logo'
        ]
    ]
];
