<?php

namespace PixlMint\WikiPlugin\Repository;

use Nacho\ORM\AbstractRepository;
use PixlMint\WikiPlugin\Model\NavCache;

class NavCacheRepository extends AbstractRepository
{
    public static function getDataName(): string
    {
        return 'nav_cache';
    }

    protected static function getModel(): string
    {
        return NavCache::class;
    }
}