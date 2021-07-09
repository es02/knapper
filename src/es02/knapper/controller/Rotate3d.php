<?php
namespace es02\knapper\controller;

use es02\knapper\model\Item;
use es02\knapper\model\Box;

class Rotate3d extends Rotate2d
{

    public function __construct()
    {
        //
    }

    public function rotateZ(item $item):void
    {
        $length = $item->length;
        $height = $item->height;

        $item->length = $height;
        $item->height = $length;
    }
}
