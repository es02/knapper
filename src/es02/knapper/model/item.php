<?php

namespace es02\Knapper\model;

use es02\Knapper\controller\Utilities;

class Item extends Primitive
{
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
}
