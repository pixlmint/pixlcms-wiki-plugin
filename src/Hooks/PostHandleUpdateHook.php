<?php

namespace PixlMint\WikiPlugin\Hooks;

use Nacho\Contracts\Hooks\PostHandleUpdate;
use Nacho\Models\PicoPage;
use PixlMint\WikiPlugin\Helpers\NavRenderer;

class PostHandleUpdateHook implements PostHandleUpdate
{
    private NavRenderer $navRenderer;

    public function __construct(NavRenderer $navRenderer) {
        $this->navRenderer = $navRenderer;
    }

    public function call(PicoPage $updatedEntry): void
    {
        $this->navRenderer->loadNav([], true);
    }
}