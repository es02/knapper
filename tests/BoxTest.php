<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use es02\Knapper\model\Box;

class BoxTest extends TestCase
{
    private $boxTests = array(
        array(
            'length' => 10,
            'width' => 50,
            'height' => 200,
            'weight' => 2
        ),
    );

    public function testCreate(): void
    {
        foreach ($this->boxTests as $test) {
            $lengthType = 'cm';
            $weightType = 'g';
            $thisWayUp =  false;

            // Make testcase writing easier
            if(isset($test['lengthType'])){
                $lengthType = $test['lengthType'];
            }
            if(isset($test['weightType'])){
                $weightType = $test['weightType'];
            }
            if(isset($test['thisWayUp'])){
                $thisWayUp = $test['thisWayUp'];
            }

            $box = new Box($test);
            $this->assertObjectHasAttribute('length', $box);
            $this->assertObjectHasAttribute('width', $box);
            $this->assertObjectHasAttribute('height', $box);
            $this->assertObjectHasAttribute('weight', $box);
            $this->assertObjectHasAttribute('cubic', $box);
            $this->assertObjectHasAttribute('lengthType', $box);
            $this->assertObjectHasAttribute('weightType', $box);
            $this->assertObjectHasAttribute('thisWayUp', $box);

            $this->assertEquals($box->length, $test['length']);
            $this->assertEquals($box->width, $test['width']);
            $this->assertEquals($box->height, $test['height']);
            $this->assertEquals($box->weight, $test['weight']);
            $this->assertEquals($box->lengthType, $lengthType);
            $this->assertEquals($box->weightType, $weightType);
            $this->assertEquals($box->thisWayUp, $thisWayUp);
            $this->assertEquals($box->cubic, $test['length'] * $test['width'] * $test['height']);
            unset($box);
        }
    }
}
