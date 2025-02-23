<?php

namespace PixlMint\WikiPlugin\Repository;

use Nacho\ORM\AbstractRepository;
use PixlMint\WikiPlugin\Model\SvgDrawing;

class SvgDrawingRepository extends AbstractRepository
{
    public function findBySvgPath(string $path): ?SvgDrawing
    {
        return $this->findWithCallback(function(array $datum) use ($path) {
            return $datum['svg'] === $path;
        });
    }

    public static function getDataName(): string
    {
        return 'svg-drawing';
    }

    public static function getModel(): string
    {
        return SvgDrawing::class;
    }

    private function findWithCallback(callable $identifier): ?SvgDrawing
    {
        foreach ($this->getData() as $id => $datum) {
            if ($identifier($datum)) {
                return new SvgDrawing($id, $datum['svg'], $datum['compressedData']);
            }
        }
        return null;
    }
}
