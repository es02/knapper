<?php

namespace es02\Knapper\model;

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

    /**
     * Determines if we process in 3D or 2D
     * important for fragile and dangerous goods.
     * @var bool
     */
    public $thisWayUp =  false;

    /**
     * Once sorted we store box number here
     * @var integer
     */
    public $box = null;

    /**
     * Handle not being able to pack the item into a box
     * Item will need seperate packing or a new box size added to accommodate..
     * @var bool
     */
    public $noBox = false;

    /**
     * Location coordinates for the item in the box.
     * Allows us to test for overlaps in 3 dimensions when placing items.
     * Kept to whole numbers (rounded up) for simplicity.
     * @var integer
     */
    public $x = 0;
    public $y = 0;
    public $z = 0;

    public function __construct(array $item)
    {
        $this->length = $item['length'];
        $this->width = $item['width'];
        $this->height = $item['height'];
        $this->weight = $item['weight'];

        // If not set leave on sane defaults
        if (isset($item['lengthType']) and !empty($item['lengthType'])) {
            $this->lengthType = $item['lengthType'];
        }
        if (isset($item['weightType']) and !empty($item['weightType'])) {
            $this->weightType = $item['weightType'];
        }
        if (isset($item['thisWayUp']) and !empty($item['thisWayUp'])) {
            $this->thisWayUp = $item['thisWayUp'];
        }
        if (isset($item['name']) and !empty($item['name'])) {
            $this->name = $item['name'];
        }

        $this->cubic = $item['length'] * $item['width'] * $item['height'];
    }
}
