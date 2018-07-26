<?php

namespace es02\Knapper\model;

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
     * Optional identifier
     * @var string
     */
    public $name = null;

    /**
     * Do we have a limited number of this box size?
     * Assume no.
     * @var integer
     */
    public $quantity = 0;
    public $remaining = 0;

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
    public $thisWayUp =  false;

    public function __construct(array $box)
    {
        $this->length = $box['length'];
        $this->width = $box['width'];
        $this->height = $box['height'];
        $this->weight = $box['weight'];

        // If not set leave on sane defaults
        if (isset($box['lengthType']) and !empty($box['lengthType'])) {
            $this->lengthType = $box['lengthType'];
        }
        if (isset($box['weightType']) and !empty($box['weightType'])) {
            $this->weightType = $box['weightType'];
        }
        if (isset($box['quantity']) and !empty($box['quantity'])) {
            $this->quantity = $box['quantity'];
            $this->remaining = $box['quantity'];
        }
        if (isset($item['name']) and !empty($item['name'])) {
            $this->name = $item['name'];
        }

        $this->cubic = $box['length'] * $box['width'] * $box['height'];
    }
}
