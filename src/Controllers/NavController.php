<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Controllers\AbstractController;
use Nacho\Models\HttpResponse;
use PixlMint\WikiPlugin\Helpers\NavRenderer;

class NavController extends AbstractController
{
    public function loadNav(NavRenderer $navRenderer): HttpResponse
    {
        return $this->json($navRenderer->loadNav());
    }
}