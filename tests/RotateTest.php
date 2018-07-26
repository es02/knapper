<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use es02\Knapper\controller\Rotate2d;
use es02\Knapper\controller\Rotate3d;
use es02\Knapper\model\Item;

class RotateTest extends TestCase
{
    private $itemTests = array(
        array(
            'length' => 10,
            'width' => 50,
            'height' => 200,
            'weight' => 2
        ),
    );

    public function testCanRotate(): void
    {
        $rotate2d = new Rotate2d;
        $rotate3d = new Rotate3d;

        foreach ($this->itemTests as $test) {
            $item = new Item($test);

            $rotate2d->rotateXY($item);
            $this->assertEquals($item->length, $test['width']);
            $this->assertEquals($item->width, $test['length']);
            $this->assertEquals($item->height, $test['height']);

            $rotate3d->rotateXY($item);
            $this->assertEquals($item->length, $test['length']);
            $this->assertEquals($item->width, $test['width']);
            $this->assertEquals($item->height, $test['height']);

            $rotate3d->rotateZ($item);
            $this->assertEquals($item->length, $test['height']);
            $this->assertEquals($item->width, $test['width']);
            $this->assertEquals($item->height, $test['length']);

            unset($item);
        }
    }
}
