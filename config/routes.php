<?php

use PixlMint\JournalPlugin\Controllers\AdminController;
use PixlMint\JournalPlugin\Controllers\CacheController;
use PixlMint\JournalPlugin\Controllers\EntriesController;
use PixlMint\WikiPlugin\Controllers\IndexingController;
use PixlMint\WikiPlugin\Controllers\NavController;

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
];