<?php

namespace es02\knapper\model;

class Box
{
    /**
     * Sets gross box measurements
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

    public function _construct(array $box)
    {
        $this->length = $box[length];
        $this->width = $box[width];
        $this->height = $box[height];
        $this->weight = $box[weight];

        // If not set leave on sane defaults
        if(isset($box[lengthType]) AND !empty($box[lengthType])){
            $this->lengthType = $box[lengthType];
        }
        if(isset($box[weightType]) AND !empty($box[weightType])){
            $this->weightType = $box[weightType];
        }
        if(isset($box[thisWayUp]) AND !empty($box[thisWayUp])){
            $this->thisWayUp = $box[thisWayUp];
        }

        $this->cubic = $box[length] * $box[width] * $box[height];
    }
}
