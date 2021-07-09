<?php

namespace es02\knapper\model;

use es02\knapper\controller\Utilities;

class Primitive
{
    /**
     * Sets gross item measurements
     * @var float
     */
    public $length = 0.0;
    public $width = 0.0;
    public $height = 0.0;
    public $weight = 0.0;

    /**
     * Optional identifier
     * @var string
     */
    public $name = null;

    /**
     * Store calculated cubic measurement
     * @var float
     */
    public $cubic = 0.0;

    /**
     * Sets measurement system and units (Metric/Imperial)(Small/Large)
     * @var string
     */
    public $lengthType = 'cm'; // cm, m, in, ft
    public $weightType = 'g';  // g, kg, oz, lb
    public $originalLengthType = 'cm'; // cm, m, in, ft
    public $originalWeightType = 'g';  // g, kg, oz, lb

    /**
     * Determines if we process in 3D or 2D
     * important for fragile and dangerous goods.
     * @var bool
     */
    public $thisWayUp =  false;

    public function __construct(array $object)
    {
        $this->length = $object['length'];
        $this->width = $object['width'];
        $this->height = $object['height'];
        $this->weight = $object['weight'];

        $this->cubic = $object['length'] * $object['width'] * $object['height'] / 4000;

        // If not set leave on sane defaults
        if (isset($object['lengthType']) and !empty($object['lengthType'])) {
            $this->originalLengthType = $object['lengthType'];

            // Standardise into neat metric units to make packing easier
            $this->length = Utilities::convert(
                $this->originalLengthType,
                $this->lengthType,
                $object['length']
            );
            $this->width = Utilities::convert(
                $this->originalLengthType,
                $this->lengthType,
                $object['width']
            );
            $this->height = Utilities::convert(
                $this->originalLengthType,
                $this->lengthType,
                $object['height']
            );
        }
        if (isset($object['weightType']) and !empty($object['weightType'])) {
            $this->originalWeightType = $object['weightType'];

            // Standardise into neat metric units to make packing easier
            $this->weight = Utilities::convert(
                $this->originalWeightType,
                $this->weightType,
                $object['weight']
            );
        }
        if (isset($object['thisWayUp']) and !empty($object['thisWayUp'])) {
            $this->thisWayUp = $object['thisWayUp'];
        }
        if (isset($object['name']) and !empty($object['name'])) {
            $this->name = $object['name'];
        }
    }
}
