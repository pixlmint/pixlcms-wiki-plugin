<?php

namespace PixlMint\WikiPlugin\Helpers;

use Exception;
use Nacho\Contracts\PageManagerInterface;
use Nacho\Helpers\AlternativeContentPageHandler;
use Nacho\Models\PicoPage;
use PixlMint\CMS\Helpers\Stopwatch;
use PixlMint\WikiPlugin\Model\Index;
use PixlMint\WikiPlugin\Repository\IndexRepository;
use Psr\Log\LoggerInterface;
use Smalot\PdfParser\Parser;

class Indexer
{
    private array $index = [];
    private PageManagerInterface $pageManager;
    private IndexRepository $indexRepository;
    private AlternativeContentPageHandler $alternativeContentPageHandler;
    private array $errorBucket;
    private LoggerInterface $logger;

    public function __construct(PageManagerInterface $pageManager, IndexRepository $indexRepository, AlternativeContentPageHandler $alternativeContentPageHandler, LoggerInterface $logger)
    {
        $this->pageManager = $pageManager;
        $this->indexRepository = $indexRepository;
        $this->alternativeContentPageHandler = $alternativeContentPageHandler;
        $this->logger = $logger;
    }

    public function indexDb(): float
    {
        $pages = $this->pageManager->getPages();
        $timer = Stopwatch::startNew();
        foreach ($pages as $page) {
            try {
                $this->indexPage($page);
            } catch (Exception $e) {
                $this->errorBucket[] = $e;
                $this->logger->warning(sprintf("Error in indexer: %s", $e->getMessage()));
            }
        }
        $indexTime = $timer->stop();
        if ($this->errorBucket) {
            $this->logger->warning(sprintf('Indexer ran with %d errors within %ds', count($this->errorBucket), $indexTime));
        } else {
            $this->logger->info(sprintf('Indexer ran within %ds', $indexTime));
        }

        $index = new Index($indexTime, $this->index);
        $this->indexRepository->set($index);

        return $indexTime;
    }

    private function indexPage(PicoPage $page): void
    {
        $title = strtolower($page->meta->title);
        $this->indexString($title, $page->id, 10);

        if (key_exists('renderer', $page->meta->toArray()) && $page->meta->renderer === 'pdf') {
            $this->indexPdf($page);
        } else {
            $this->indexString($page->raw_content, $page->id, 3);
        }
    }

    private function indexPdf(PicoPage $page): void
    {
        $this->alternativeContentPageHandler->setPage($page);
        $pdfPath = $this->alternativeContentPageHandler->getAbsoluteFilePath();
        $parser = new Parser();
        $pdfContent = $parser->parseFile($pdfPath);
        $this->indexString($pdfContent->getText(), $page->id, 1);
    }

    private function indexString(string $str, string $pageId, int $weight): void
    {
        $str = preg_replace("/\W+/", " ", $str);
        $words = preg_split('/\s+/', $str);
        foreach ($words as $word) {
            if (!in_array($word, self::getStopWords()) && strlen($word) > 2) {
                if (!key_exists($word, $this->index)) {
                    $this->index[$word] = [];
                }
                foreach ($this->index[$word] as $position => $indexedPage) {
                    if ($indexedPage['pageId'] === $pageId) {
                        $this->index[$word][$position]['weight'] += $weight;
                        continue 2;
                    }
                }
                $this->index[$word][] = ["pageId" => $pageId, "weight" => $weight];
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