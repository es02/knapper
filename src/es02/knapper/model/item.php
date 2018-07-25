<?php

namespace es02\knapper\model;

class Item
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

    /**
     * Determines if we process in 3D or 2D
     * important for fragile and dangerous goods.
     * @var bool
     */
    private $thisWayUp =  false;

    /**
     * Once sorted we store box number here
     * @var integer
     */
    public $box = null;

    public function _construct(array $item)
    {
        $this->length = $item[length];
        $this->width = $item[width];
        $this->height = $item[height];
        $this->weight = $item[weight];

        // If not set leave on sane defaults
        if(isset($item[lengthType]) AND !empty($item[lengthType])){
            $this->lengthType = $item[lengthType];
        }
        if(isset($item[weightType]) AND !empty($item[weightType])){
            $this->weightType = $item[weightType];
        }
        if(isset($item[thisWayUp]) AND !empty($item[thisWayUp])){
            $this->thisWayUp = $item[thisWayUp];
        }

        $this->cubic = $item[length] * $item[width] * $item[height];
    }
}
