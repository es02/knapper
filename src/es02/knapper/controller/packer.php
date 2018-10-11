<?php
namespace es02\knapper\controller;

use es02\knapper\controller\Utilities;
use es02\knapper\controller\Rotate2d;
use es02\knapper\controller\Rotate3d;
use es02\knapper\model\Item;

class Packer
{
    private $packed = array();
    private $boxID = null;
    private $itemID = null;

    public function __construct()
    {
        //
    }

    /**
    * Wrapper for solver - cuts memory usage and reduces liklihood of leaks
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
        // Keep iterating through items and boxes until we run out.
        while ($this->findItem($items, $maxCubic, $maxWeight, $weightType) === true) {
            $this->packer($items, $boxes, $maxCubic, $maxWeight, $weightType);
        }
        return $this->packed;
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
    public function packer(
        array $items,
        array $boxes,
        float $maxCubic = null,
        float $maxWeight = null,
        string $weightType = null
    ) {
        // Start by finding an appropriate box
        if (is_null($this->findBox($items[$this->itemID], $boxes))) {
            $items[$this->itemID]->noBox = true;
            $this->packed['seperate'][] = $items[$this->itemID];
            return null;
        }

        // Are we packing an existing box or do we need to start a new one?
        if (is_null($this->boxID) and !$items[$this->itemID]->noBox) {
            $this->boxID = $this->findBox($items[$this->itemID], $boxes);
            $this->packed[$this->boxID] = $boxes[$this->boxID];
        }

        // if we have a box but no item then consider the box full and we'll
        // open a new one on the next pass.
        if (is_null($itemID)) {
            $this->boxID = null;
        } elseif ($this->fitCheck($itemID, $this->boxID, $items[$this->itemID])) {
            $items[$this->itemID]->box = $this->boxID;
            $this->packed[$this->boxID][] = $items[$this->itemID];
        }
    }

    /**
     * Does the item fit in the box?
     * @param  integer $itemID Item we're fitting
     * @param  integer $boxID  Box we're trying to fit it into
     * @param  item    $item   Item we're fitting's object
     * @return bool
     */
    private function fitCheck(
        int $itemID,
        int $boxID,
        Item $items
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

        $item = $items[$itemID];

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
    private function findBox(Item $item, array $boxes)//:integer
    {
        foreach ($boxes as $key => $box) {
            // loop for rotations so we don't discard a box that fits
            for ($i = 1; $i <= 3; $i++) {
                // find the first box that will accomodate our item
                if ($box->length >= $item->length and
                $box->width >= $item->width and
                $box->height >= $item->height) {
                    return $key;
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
        }
        return null;
    }

    /**
     * [findItem description]
     * @param  array  $items      [description]
     * @param  [type] $maxCubic   [description]
     * @param  [type] $maxWeight  [description]
     * @param  [type] $weightType [description]
     * @return integer or null    [description]
     */
    private function findItem(
        array $items,
        float $maxCubic = null,
        float $maxWeight = null,
        string $weightType = null
    ) {
        $longest = 0;
        $itemID = null;
        foreach ($items as $key => $item) {
            if (!empty($item->box) or $item->noBox === true) {
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
            if (!is_null($maxCubic) and $cubeTemp > $maxCubic) {
                $item->noBox = true;
                $this->packed['seperate'][] = $item;
                continue;
            }
            if (!is_null($maxWeight) and $weightTemp > $maxWeight) {
                $item->noBox = true;
                $this->packed['seperate'][] = $item;
                continue;
            }

            // find longest side and see if it's the biggest we've seen
            $check = max($item->length, $item->width, $item->height);
            if ($check > $longest) {
                $longest = $check;
                $this->itemID = $key;
                return true;
            }
        }
        return false;
    }
}
