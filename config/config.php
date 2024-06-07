<?php

use PixlMint\WikiPlugin\Hooks\InitHook;
use PixlMint\WikiPlugin\Hooks\PostHandleUpdateHook;

return [
    'routes' => require_once('routes.php'),
    'wiki' => require_once('wiki.php'),
    'hooks' => [
        [
            'anchor' => 'init',
            'hook' => InitHook::class,
        ],
        [
            'anchor' => 'post_handle_update',
            'hook' => PostHandleUpdateHook::class,
        ]
    ]
];