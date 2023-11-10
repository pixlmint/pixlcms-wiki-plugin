<?php

use PixlMint\WikiPlugin\Hooks\InitHook;

return [
    'routes' => require_once('routes.php'),
    'wiki' => require_once('wiki.php'),
    'hooks' => [
        [
            'anchor' => 'init',
            'hook' => InitHook::class,
        ],
    ]
];