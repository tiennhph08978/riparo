<?php

return [
    'admin' => [
        [
            'icon' => '<i class="fa-solid fa-people-group"></i>',
            'title' => 'ユーザー管理',
            'route' => 'admin.manager-user.index',
            'route_active' => [
                'admin.manager-user.index',
                'admin.manager-user.detail',
                'admin.manager-user.update',
            ],
        ],
        [
            'icon' => '<i class="fa-solid fa-list"></i>',
            'title' => 'プロジェクト管理',
            'route' => 'admin.projects.index',
            'route_active' => [
                'admin.projects.index',
                'admin.projects.detail',
                'admin.projects.user.dedications',
            ],
        ],
        [
            'icon' => '<i class="fas fa-cog"></i>',
            'title' => '設定',
            'route_active' => [
                'admin.edit-email.index',
                'admin.receive-email.index',
            ],
            'childs' => [
                [
                    'title' => 'ユーザーのメール管理',
                    'route' => 'admin.edit-email.index',
                    'icon' => '<i class="fa-solid fa-list"></i>',
                ],
                [
                    'title' => '受領メール',
                    'route' => 'admin.receive-email.index',
                    'icon' => '<i class="fa-solid fa-list"></i>',
                ],
            ],
        ],
    ],
];
