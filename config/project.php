<?php

return [
    'filter' => [
        1 => 'recent_time',
        2 => 'shortest_time',
        3 => 'stock_ratio',
    ],

    'filter_map' => [
        'recent_time' => 1,
        'shortest_time' => 2,
        'stock_ratio' => 3,
    ],

    'contract_period_reach' => [
        1 => '1_day',
        2 => '1_week',
        3 => '1_month',
        4 => '3_month',
        5 => '6_month',
        6 => '12_month',
    ],

    'contract_period_reach_day' => [
        1 => '1',
        2 => '7',
        3 => '30',
        4 => '90',
        5 => '180',
        6 => '365',
    ],

    'role' => [
        0 => 'guest',
        1 => 'owner',
        2 => 'member',
    ],

    'request_type' => [
        0 => 'research',
        1 => 'join_now',
    ],

    'contact_type' => [
        0 => 'email',
        1 => 'phone',
        2 => 'both',
    ],
];
