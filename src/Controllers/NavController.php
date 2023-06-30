<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Controllers\AbstractController;
use PixlMint\WikiPlugin\Helpers\NavRenderer;

class NavController extends AbstractController
{
    public function loadNav(): string
    {
        $navRenderer = new NavRenderer($this->nacho);

        return $this->json($navRenderer->loadNav());
    }
}