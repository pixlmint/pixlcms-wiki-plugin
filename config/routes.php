<?php

use PixlMint\JournalPlugin\Controllers\AdminController;
use PixlMint\JournalPlugin\Controllers\CacheController;
use PixlMint\JournalPlugin\Controllers\EntriesController;
use PixlMint\WikiPlugin\Controllers\IndexingController;
use PixlMint\WikiPlugin\Controllers\NavController;
use PixlMint\WikiPlugin\Controllers\SearchController;
use PixlMint\WikiPlugin\Controllers\SvgController;

return [
    [
        'route' => '/api/nav',
        'controller' => NavController::class,
        'function' => 'loadNav',
    ],
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
];