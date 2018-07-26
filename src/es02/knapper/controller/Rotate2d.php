<?php
namespace es02\Knapper\controller;

use es02\knapper\model\Item;
use es02\knapper\model\Box;

class Rotate2d
{

    public function __construct()
    {
        //
    }

    public function rotateX(item $item)
    {
        $length = null;
        $width = null;

        $item->length = $width;
        $item->width = $length;

        return $item;
    }
}
