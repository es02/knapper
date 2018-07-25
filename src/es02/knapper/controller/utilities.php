<?php
namespace es02\knapper\controller;

class Utilities {
    private $measurementTypes = array(
        'cm',
        'm',
        'in',
        'ft',
        'g',
        'kg',
        'oz',
        'lb'
    );

    /**
     * Conversion multipliers
     * @var array
     */
    private $converters = array(
        'cm' => array(
            'cm' => 1,
            'm' => 0.01,
            'in' => 0.3937008,
            'ft' => 0.0328084
        ),
        'm' => array(
            'cm' => 100,
            'm' => 1,
            'in' => 39.3701,
            'ft' => 3.28084
        ),
        'in' => array(
            'cm' => 2.54,
            'm' => 0.0254,
            'in' => 1,
            'ft' => 0.0833333
        ),
        'ft' => array(
            'cm' => 30.48,
            'm' => 0.3048,
            'in' => 12,
            'ft' => 1
        ),
        'g' => array(
            'g' => 1,
            'kg' => 0.01,
            'oz' => 0.035274,
            'lb' => 0.00220462
        ),
        'kg' => array(
            'g' => 100,
            'kg' => 1,
            'oz' => 0.035274,
            'lb' => 2.20462
        ),
        'oz' => array(
            'g' => 28.3495,
            'kg' => 0.0283495,
            'oz' => 1,
            'lb' => 0.0625
        ),
        'lb' => array(
            'g' => 453.592,
            'kg' => 0.453592,
            'oz' => 16,
            'lb' => 1
        )
    );

    public function convert($amount, $from, $to){
        if(
            !in_array($from, $this->measurementTypes) OR
            !in_array($to, $this->measurementTypes)
        ){
            // Something has gone very wrong here.
            throw new \Exception("Invalid measurement type(s) specified for conversion");
        }

        return $amount * $this->converters[$from][$to];
    }
}
