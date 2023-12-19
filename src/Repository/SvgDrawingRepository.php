<?php

namespace PixlMint\WikiPlugin\Repository;

use Nacho\ORM\AbstractRepository;
use PixlMint\WikiPlugin\Model\SvgDrawing;

class SvgDrawingRepository extends AbstractRepository
{
    public function findBySvgPath(string $path): ?SvgDrawing
    {
        foreach ($this->getData() as $datum) {
            if ($datum['svg'] === $path) {
                return new SvgDrawing($datum['id'], $datum['svg'], $datum['data']);
            }
        }

        return null;
    }

    public static function getDataName(): string
    {
        return 'svg-drawing';
    }

    public static function getModel(): string
    {
        return SvgDrawing::class;
    }
}