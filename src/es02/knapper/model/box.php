<?php

namespace es02\knapper\model;

class Box extends Primitive
{
    /**
     * Do we have a limited number of this box size?
     * Assume no.
     * @var integer
     */
    public $quantity = 0;
    public $remaining = 0;
}
