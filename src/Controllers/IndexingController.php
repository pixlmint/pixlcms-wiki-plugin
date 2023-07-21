<?php

namespace PixlMint\WikiPlugin\Controllers;

use Nacho\Controllers\AbstractController;
use PixlMint\WikiPlugin\Helpers\Indexer;

class IndexingController extends AbstractController
{
    public function index(): string
    {
        $indexer = new Indexer();
        $indexTime = $indexer->indexDb($this->nacho);

        return $this->json(['message' => 'success', 'indexTime' => $indexTime]);
    }
}