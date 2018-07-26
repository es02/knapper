<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use es02\Knapper\model\Item;

class ItemTest extends TestCase
{
    private $itemTests = array(
        array(
            'length' => 10,
            'width' => 50,
            'height' => 200,
            'weight' => 2
        ),
    );

    public function testCreate(): void
    {
        foreach ($this->itemTests as $test) {
            $lengthType = 'cm';
            $weightType = 'g';
            $thisWayUp =  false;
            $box = null;

            // Make testcase writing easier
            if (isset($test['lengthType'])){
                $lengthType = $test['lengthType'];
            }
            if (isset($test['weightType'])){
                $weightType = $test['weightType'];
            }
            if (isset($test['thisWayUp'])){
                $thisWayUp = $test['thisWayUp'];
            }

            $item = new Item($test);
            $this->assertObjectHasAttribute('length', $item);
            $this->assertObjectHasAttribute('width', $item);
            $this->assertObjectHasAttribute('height', $item);
            $this->assertObjectHasAttribute('weight', $item);
            $this->assertObjectHasAttribute('cubic', $item);
            $this->assertObjectHasAttribute('lengthType', $item);
            $this->assertObjectHasAttribute('weightType', $item);
            $this->assertObjectHasAttribute('thisWayUp', $item);
            $this->assertObjectHasAttribute('box', $item);

            $this->assertEquals($item->length, $test['length']);
            $this->assertEquals($item->width, $test['width']);
            $this->assertEquals($item->height, $test['height']);
            $this->assertEquals($item->weight, $test['weight']);
            $this->assertEquals($item->lengthType, $lengthType);
            $this->assertEquals($item->weightType, $weightType);
            $this->assertEquals($item->thisWayUp, $thisWayUp);
            $this->assertEquals($item->box, $box);
            $this->assertEquals($item->cubic, $test['length'] * $test['width'] * $test['height']);
            unset($item);
        }
    }
}
