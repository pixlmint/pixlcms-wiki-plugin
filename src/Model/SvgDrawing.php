<?php

namespace PixlMint\WikiPlugin\Model;

use Nacho\Contracts\ArrayableInterface;
use Nacho\ORM\AbstractModel;
use Nacho\ORM\ModelInterface;
use Nacho\ORM\TemporaryModel;

class SvgDrawing extends AbstractModel implements ModelInterface, ArrayableInterface
{
    private string $svg;
    private array $data;

    public static function init(TemporaryModel $data, int $id): ModelInterface
    {
        $drawing = new SvgDrawing($id, $data->get('svg'), $data->get('data')->asArray());
        return $drawing;
    }

    public function __construct(int $id, string $svg, array $data)
    {
        $this->id = $id;
        $this->svg = $svg;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'svg' => $this->svg,
            'data' => $this->data,
        ];
    }

    public function getSvg(): string
    {
        return $this->svg;
    }

    public function setSvg(string $svg): void
    {
        $this->svg = $svg;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}