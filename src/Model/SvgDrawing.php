<?php

namespace PixlMint\WikiPlugin\Model;

use Nacho\Contracts\ArrayableInterface;
use Nacho\ORM\AbstractModel;
use Nacho\ORM\ModelInterface;
use Nacho\ORM\TemporaryModel;

class SvgDrawing extends AbstractModel implements ModelInterface, ArrayableInterface
{
    private string $svg;
    private array $data = [];
    private string $compressedData;

    public static function init(TemporaryModel $data, int $id): ModelInterface
    {
        return new SvgDrawing($id, $data->get('svg'), $data->get('compressedData'));
    }

    public function __construct(int $id, string $svg, mixed $compressedData)
    {
        $this->id = $id;
        $this->svg = $svg;
        if (is_array($compressedData)) {
            $this->data = $compressedData;
        } else {
            $this->compressedData = $compressedData;
        }
    }

    public function toArray(): array
    {
        $this->compressData();
        return [
            'svg' => $this->svg,
            'compressedData' => $this->compressedData,
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
        $this->decompressData();
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    private function compressData(): void
    {
        $this->compressedData = base64_encode(gzdeflate(json_encode($this->data)));
    }

    private function decompressData(): void
    {
        if ($this->data) {
            return;
        }

        $decompressed = gzinflate(base64_decode($this->compressedData));
        $this->data = json_decode($decompressed, true);
    }
}
