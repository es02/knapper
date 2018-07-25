<?php
namespace es02\knapper\controller;

use es02\knapper\model\Item;
use es02\knapper\model\Box;

class 3dRotate extends 2dRotate{

    public function _construct()
    {
        //
    }

    public function rotateZ(item $item)
    {
        $length = null;
        $height = null;

        $item->length = $height;
        $item->height = $length;

        return $item;
    }
}
?>
