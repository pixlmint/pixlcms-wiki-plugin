<?php

use PixlMint\WikiPlugin\Controllers\IndexingController;
use PixlMint\WikiPlugin\Controllers\SearchController;
use PixlMint\WikiPlugin\Controllers\SvgController;

return [
    [
        'route' => '/api/index',
        'controller' => IndexingController::class,
        'function' => 'index',
    ],
    [
        'route' => '/api/search',
        'controller' => SearchController::class,
        'function' => 'search',
    ],
    [
        'route' => '/api/admin/svg/store-data',
        'controller' => SvgController::class,
        'function' => 'storeSvgData',
    ],
    [
        'route' => '/api/admin/svg/load-data',
        'controller' => SvgController::class,
        'function' => 'loadSvgData',
    ],
];
