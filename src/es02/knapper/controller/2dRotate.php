<?php
namespace es02\knapper\controller;

use es02\knapper\model\Item;
use es02\knapper\model\Box;

class 2dRotate{

    public function _construct()
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
?>
