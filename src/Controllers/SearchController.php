<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Controllers\AbstractController;
use Nacho\Models\HttpResponse;
use Nacho\Models\Request;
use PixlMint\WikiPlugin\Helpers\SearchHelper;

class SearchController extends AbstractController
{
    public function search(Request $request): HttpResponse
    {
        $searchHelper = new SearchHelper();

        $query = $request->getBody()['q'];

        $result = $searchHelper->search($query);

        return $this->json($result);
    }
}