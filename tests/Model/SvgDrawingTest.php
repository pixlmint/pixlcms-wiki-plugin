<?php

namespace PixlMint\WikiPlugin\Tests\Model;

use PHPUnit\Framework\TestCase;
use PixlMint\WikiPlugin\Model\SvgDrawing;

class SvgDrawingTest extends TestCase
{
    private string $testData = '{"svg":"/media/CP2077/iconic-weapons/422a427d4398135b28298dc2f9b5c9139fdf9fde1703257884738.svg","data":{"paths":[{"points":[{"x":534,"y":65,"speed":0,"pressure":0.5},{"x":517,"y":88,"speed":0,"pressure":0.5}],"color":"#000","baseWeight":1,"drawingMode":{"name":"Freehand","icon":"hand"}}],"meta":{"width":1214,"height":839}}}';
    private string $testCompressedData = 'dU9NT4UwEPwv67U++kHtx9XEm4k3D+Kh0AWaSEsoiuaF/255ePWw2ZnNZHbmCvlrAAtNNaEPrqkeXzhVqqlCl2Lo7jd0c4q5qWrOXc2Vr4XRTMiWa26073hvWtkZJkzv+zLIFBVcKq1rJfTlMCfg3erAXmF265jBvhWUQlxP+A1WiprAD9gHSSDPiB4sJTAvmPPngoVc5E5OJVM3pdb/K98JdOkjLaXVHaW0/G9dxlcMw7iCZSXO4rYQh+fk8UgV3VQ2PC2Io4u+6I/u5XJj++E34VlgC34diwdnJfD456iF2ff9Fw==';

    public function testInitialization()
    {
        $drawing1 = new SvgDrawing(-1, 'svg', $this->getData());
        $this->assertEquals($this->testCompressedData, $drawing1->toArray()['compressedData']);

        $drawing2 = new SvgDrawing(-1, 'svg', $this->testCompressedData);
        $this->assertEquals($this->getData(), $drawing2->getData());
    }

    private function getData(): array
    {
        return json_decode($this->testData, true);
    }
}