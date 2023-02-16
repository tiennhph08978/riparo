<?php

return [
    'image_types' => [
        'avatar' => [
            'crop' => true,
            'full_size' => [360, 360],
            'thumb_size' => [100, 100],
        ],
        'comment' => [
            'crop' => true,
            'full_size' => [640, 640],
            'thumb_size' => [100, 100],
        ],
        'logo' => [
            'crop' => true,
            'full_size' => [360, 360],
            'thumb_size' => [100, 100],
        ],
        'tinymce' => [
            'crop' => false,
            'full_size' => [1000, 1000],
            'thumb_size' => [300, 300],
        ],
    ],

    'path_origin_image' => 'originals',
    'path_thumbnail' => 'thumbnails',
    'disk' => env('IMAGE_DISK', 'project'),
    'disk_temp' => env('IMAGE_TEMP_DISK', 'images_temp'),
    'webp_ext' => 'webp',
    'webp_quality' => env('IMAGE_WEBP_QUALITY', 90),
    'project_prefix' => 'storage/project/',
    'avatar_prefix' => 'storage/avatar/',
];
