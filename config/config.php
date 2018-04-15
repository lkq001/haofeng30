<?php

return [
    // 仓库类型配置
    'repertory' => [
        1 => '正品库',
        2 => '残品库',
        3 => '赠品库'
    ],

    // 请选择城市、仓库、片区警示信息
    'message' => [
        'city' => '请选择城市',
        'repertory' => '请选择仓库',
        'area' => '请选择片区'
    ],

    // 题图配置数量
    'top_image_number' => 5,

    // 分页
    'page_size' => env('PAGE_NUM'),
    'page_size_m' => env('PAGE_NUM_M'),
    'page_size_l' => env('PAGE_NUM_L'),
    'page_size_api' => env('PAGE_NUM_API'),

    // 产品图片
    'product_thumb' => env('PRODUCT_THUMB'),
    'card_thumb' => env('CARD_THUMB'),
    // 图片地址
    'thumb_image' => env('THUMB_IMAGE'),
    'article_image' => env('THUMB_IMAGE') . '/article/',
];
