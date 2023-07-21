<?php

namespace PixlMint\WikiPlugin\Model;

use Nacho\Contracts\ArrayableInterface;
use Nacho\ORM\AbstractModel;
use Nacho\ORM\ModelInterface;
use Nacho\ORM\TemporaryModel;

class Index extends AbstractModel implements ModelInterface, ArrayableInterface
{
    private float $indexTime;
    private array $index = [];

    public static function init(TemporaryModel $data, int $id): ModelInterface
    {
        return new Index($data->get('indexTime'), $data->get('index')->asArray());
    }

    public function __construct(float $indexTime, array $index)
    {
        $this->id = 1;
        $this->indexTime = $indexTime;
        $this->index = $index;
    }

    public function toArray(): array
    {
        return [
            'indexTime' => $this->indexTime,
            'index' => $this->index,
        ];
    }

    public function getIndexTime(): float
    {
        return $this->indexTime;
    }

    public function getIndex(): array
    {
        return $this->index;
    }
}
