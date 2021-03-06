<?php
namespace es02\Knapper\controller;

use es02\Knapper\controller\Utilities;
use es02\Knapper\controller\Rotate2d;
use es02\Knapper\controller\Rotate3d;

class Packer
{
    private $packed = array();
    private $boxID = null;

    public function __construct()
    {
        //
    }

    /**
    * Solver
    * @param  array  $items      Objects to pack
    * @param  array  $boxes      Boxes to pack into
    * @param  float  $maxCubic   Upper ceiling for box Cubic Weight (Optional)
    * @param  float  $maxWeight  Upper ceiling for box Gross Weight (Optional)
    * @param  string $weightType Used for determining upper ceiling (Optional)
    * @return array              Packed items
    */
    public function pack(
        array $items,
        array $boxes,
        float $maxCubic = null,
        float $maxWeight = null,
        string $weightType = null
    ):array {
        // Start by finding the longest dimension so we can find an
        // appropriate box
        $itemID = $this->findItem($items, $maxCubic, $maxWeight, $weightType);

        // If we've run out of items then return our pickslip data
        if (null($itemID) and null($this->boxID)) {
            return $this->packed;
        }

        // Are we packing an existing box or do we need to start a new one?
        if (null($this->boxID)) {
            $this->boxID = $this->findBox($items[$itemID], $boxes);
        }

        // if we have a box but no item then consider the box full and we'll
        // open a new one on the next pass.
        if (null($itemID)) {
            $this->boxID = null;
        } elseif ($this->fitCheck($itemID, $boxID, $items[$itemID])) {
            $item->box = $boxID;
        }

        // iterate
        $this->pack($items, $boxes, $maxCubic, $maxWeight, $weightType);
    }

    /**
     * Does the item fit in the box?
     * @param  integer $itemID Item we're fitting
     * @param  integer $boxID  Box we're trying to fit it into
     * @param  item    $item   Item we're fitting's object
     * @return bool
     */
    private function fitCheck(
        integer $itemID,
        integer $boxID,
        item $items
    ):bool {
        $availableX = $boxes[$boxID]->length;
        $availableY = $boxes[$boxID]->width;
        $availableZ = $boxes[$boxID]->height;

        foreach ($this->packed as $packed) {
            foreach ($packed as $item) {
                if (null($item->box) or $item->box !== $boxID) {
                    continue;
                }
                $availableX -= ($item->x + $item->length);
                $availableY -= ($item->y + $item->width);
                $availableZ -= ($item->z + $item->height);
            }
        }
        $item = $items;

        // Don't 3D rotate for thiswayup items
        $end = 4;
        if ($item->thisWayUp) {
            $end = 2;
        }

        for ($i = 1; $i <= $end; $i++) {
            // test fit and if not rotate
            if ($availableX >= $item->length and
                $availableY >= $item->width and
                $availableZ >= $item->height) {
                return true;
            }
            switch ($i) {
                case 1:
                    Rotate3d::rotateXY($item);
                    break;
                case 2:
                    Rotate3d::rotateZ($item);
                    break;
                case 3:
                    Rotate3d::rotateXY($item);
                    break;
                default:
                    break;
            }
        }

        // finished rotating and it still doesn't fit? fail and move on.
        return false;
    }

    /**
     * Find a box that will fit
     * @param  item    $items  item object
     * @param  array   $boxes  Array of boxes
     * @return integer         box ID
     */
    private function findBox(item $item, array $boxes):integer
    {
        foreach ($boxes as $box) {
            $boxID = null;

            // loop for rotations so we don't discard a box that fits
            for ($i = 1; $i <= 3; $i++) {
                // find the first box that will accomodate our item
                if ($box->length >= $item->length and
                $box->width >= $item->width and
                $box->height >= $item->height) {
                    return key($box);
                }
            }
        }
    }

    /**
     * [findItem description]
     * @param  array  $items      [description]
     * @param  [type] $maxCubic   [description]
     * @param  [type] $maxWeight  [description]
     * @param  [type] $weightType [description]
     * @return bool               [description]
     */
    private function findItem(
        array $items,
        float $maxCubic = null,
        float $maxWeight = null,
        string $weightType = null
    ):bool {
        $longest = 0;
        $itemID = null;
        foreach ($items as $item) {
            if (!null($item->$box or $item->noBox === true)) {
                continue;
            }

            // Skip items that exceed cubic or gross maximum
            // Put them in the Ship-Seperately pile
            $cubeTemp = $item->cubic;
            $weightTemp = $item->weight;
            if ($weightType !== $item->weightType) {
                $cubeTemp = Utilities::convert(
                    $this->$item->weightType,
                    $this->weightType,
                    $cubeTemp
                );
                $weightTemp = Utilities::convert(
                    $this->$item->weightType,
                    $this->weightType,
                    $weightTemp
                );
            }
            if (!null($maxCubic) and $cubeTemp > $maxCubic) {
                $item->noBox = true;
                $this->packed['seperate'][] = $item;
                continue;
            }
            if (!null($maxWeight) and $weightTemp > $maxWeight) {
                $item->noBox = true;
                $this->packed['seperate'][] = $item;
                continue;
            }

            // find longest side and see if it's the biggest we've seen
            $check = max($item->length, $item->width, $item->height);
            if ($check > $longest) {
                $longest = $check;
                $itemID = key($item);
            }
        }
        return $itemID;
    }
}
