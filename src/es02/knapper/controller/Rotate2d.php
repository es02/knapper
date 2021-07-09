<?php
namespace es02\knapper\controller;

use es02\knapper\model\Item;
use es02\knapper\model\Box;

class Rotate2d
{

    public function __construct()
    {
        //
    }

    public function rotateXY(item $item):void
    {
        $length = $item->length;
        $width = $item->width;

        $item->length = $width;
        $item->width = $length;
    }
}
