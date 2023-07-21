<?php

namespace PixlMint\WikiPlugin\Helpers;

use Nacho\ORM\RepositoryManager;
use PixlMint\WikiPlugin\Model\Index;
use PixlMint\WikiPlugin\Repository\IndexRepository;

class SearchHelper
{
    private array $index = [];

    public function __construct()
    {
        $this->index = $this->getIndex();
    }

    public function search(string $searchString): array
    {
        $query = strtolower($searchString);
        $results = [];

        foreach ($this->index as $word => $entries) {
            // Create a regex pattern to match the word in the query
            $pattern = '/\b' . preg_quote($word, '/') . '\b/';

            // If the pattern matches the query
            if (preg_match($pattern, $query)) {
                foreach ($entries as $entry) {
                    if (!isset($results[$entry["pageId"]])) {
                        $results[$entry["pageId"]] = 0;
                    }
                    // Accumulate weights for each matching word
                    $results[$entry["pageId"]] += $entry["weight"];
                }
            }
        }

        // Sort the results by weight in descending order
        arsort($results);

        return array_keys($results);  // Return pageId's of the results
    }

    public function getIndex(): array
    {
        if (!$this->index) {
            /** @var Index $index */
            $index = RepositoryManager::getInstance()->getRepository(IndexRepository::class)->getById(1);

            if (!$index) {
                throw new \Exception('Index is not built');
            }

            $this->index = $index->getIndex();
        }

        return $this->index;
    }

}