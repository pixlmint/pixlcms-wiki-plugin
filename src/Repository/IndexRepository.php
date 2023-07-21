<?php

namespace PixlMint\WikiPlugin\Repository;

use Nacho\ORM\AbstractRepository;
use Nacho\ORM\RepositoryInterface;
use PixlMint\WikiPlugin\Model\Index;

class IndexRepository extends AbstractRepository implements RepositoryInterface
{
    public static function getDataName(): string
    {
        return 'index';
    }

    protected static function getModel(): string
    {
        return Index::class;
    }
}