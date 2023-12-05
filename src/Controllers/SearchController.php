<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Contracts\RequestInterface;
use Nacho\Controllers\AbstractController;
use Nacho\Models\HttpResponse;
use PixlMint\WikiPlugin\Helpers\SearchHelper;

class SearchController extends AbstractController
{
    public function search(RequestInterface $request, SearchHelper $searchHelper): HttpResponse
    {
        $query = $request->getBody()['q'];

        $result = $searchHelper->search($query);

        return $this->json($result);
    }
}
