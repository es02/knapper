<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use es02\knapper\controller\Utilities;

class UtilTest extends TestCase
{
    private $converterTests = array(
        array(
            'from' => 'cm',
            'to' => 'm',
            'amount' => '200',
            'expected' => '2'
        ),
        array(
            'from' => 'in',
            'to' => 'ft',
            'amount' => '24',
            'expected' => '1.9999992' // Imperial measurements suck the proverbial
        ),
    );

    public function testCanConvert(): void
    {
        $util = new Utilities;

        foreach ($this->converterTests as $test) {
            $this->assertEquals(
                $util->convert(
                    $test['amount'],
                    $test['from'],
                    $test['to']
                ),
                $test['expected']
            );
        }
    }
}
