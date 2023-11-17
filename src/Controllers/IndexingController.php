<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Controllers\AbstractController;
use Nacho\Models\HttpResponse;
use PixlMint\WikiPlugin\Helpers\Indexer;

class IndexingController extends AbstractController
{
    public function index(Indexer $indexer): HttpResponse
    {
        $indexTime = $indexer->indexDb();

        return $this->json(['message' => 'success', 'indexTime' => $indexTime]);
    }
}