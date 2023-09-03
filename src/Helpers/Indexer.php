<?php

namespace PixlMint\WikiPlugin\Helpers;

use Nacho\Nacho;
use Nacho\ORM\RepositoryManager;
use PixlMint\CMS\Helpers\Stopwatch;
use PixlMint\WikiPlugin\Model\Index;
use PixlMint\WikiPlugin\Repository\IndexRepository;

class Indexer
{
    private array $index = [];

    public function indexDb(Nacho $nacho): float
    {
        $pages = $nacho->getPageManager()->getPages();
        $timer = Stopwatch::startNew();
        foreach ($pages as $page) {
            $content = strtolower($page->raw_content);
            $title = strtolower($page->meta->title);

            $this->indexString($content, $page->id, 1);
            $this->indexString($title, $page->id, 10);
        }
        $indexTime = $timer->stop();

        $index = new Index($indexTime, $this->index);
        RepositoryManager::getInstance()->getRepository(IndexRepository::class)->set($index);

        return $indexTime;
    }

    private function indexString(string $str, string $pageId, int $weight): void
    {
        $str = preg_replace("/\W+/", " ", $str);
        $words = preg_split('/\s+/', $str);
        foreach ($words as $word) {
            if (!in_array($word, self::getStopWords())) {
                if (!key_exists($word, $this->index)) {
                    $this->index[$word] = [];
                }
                $alreadyInArray = array_filter($this->index[$word], function($arr) use($pageId) {
                    return $pageId === $arr['pageId'];
                });
                $i = array_search($alreadyInArray, $this->index[$word]);
                if ($i) {
                    $this->index[$word][$i]['weight'] += $weight;
                } else {
                    $this->index[$word][] = ["pageId" => $pageId, "weight" => $weight];
                }
            }
        }
    }

    private static function getStopWords(): array
    {
        return [
            "",
            "a", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are", "aren't", "as", "at",
            "be", "because", "been", "before", "being", "below", "between", "both", "but", "by",
            "can't", "cannot", "could", "couldn't",
            "did", "didn't", "do", "does", "doesn't", "doing", "don't", "down", "during",
            "each",
            "few", "for", "from", "further",
            "had", "hadn't", "has", "hasn't", "have", "haven't", "having", "he", "he'd", "he'll", "he's", "her", "here", "here's", "hers", "herself", "him", "himself", "his", "how", "how's",
            "i", "i'd", "i'll", "i'm", "i've", "if", "in", "into", "is", "isn't", "it", "it's", "its", "itself",
            "let's",
            "me", "more", "most", "mustn't", "my", "myself",
            "no", "nor", "not",
            "of", "off", "on", "once", "only", "or", "other", "ought", "our", "ours", "ourselves", "out", "over", "own",
            "same", "shan't", "she", "she'd", "she'll", "she's", "should", "shouldn't", "so", "some", "such",
            "than", "that", "that's", "the", "their", "theirs", "them", "themselves", "then", "there", "there's", "these", "they", "they'd", "they'll", "they're", "they've", "this", "those", "through", "to", "too",
            "under", "until", "up",
            "very",
            "was", "wasn't", "we", "we'd", "we'll", "we're", "we've", "were", "weren't", "what", "what's", "when", "when's", "where", "where's", "which", "while", "who", "who's", "whom", "why", "why's", "with", "won't", "would", "wouldn't",
            "you", "you'd", "you'll", "you're", "you've", "your", "yours", "yourself", "yourselves"
        ];
    }
}