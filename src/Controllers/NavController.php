<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Contracts\RequestInterface;
use Nacho\Controllers\AbstractController;
use Nacho\Models\HttpResponse;
use PixlMint\WikiPlugin\Helpers\NavRenderer;

class NavController extends AbstractController
{
    public function loadNav(NavRenderer $navRenderer, RequestInterface $request): HttpResponse
    {
        $forceRerender = false;
        if ($request->getBody()->has('forceReload')) {
            $forceRerender = true;
        }
        return $this->json($navRenderer->loadNav([], $forceRerender));
    }
}