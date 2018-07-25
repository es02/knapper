<?php
namespace es02\knapper;

use es02\knapper\model\item;
use es02\knapper\model\box;

/**
 * Knapper: A simple, dependancy free knapsack solver intended for optimizing
 * shipping boxes based on both physical dimensions and cubic weight.
 */

class Knapper
{
    /**
     * Allows the maximum cubic weight for the boxes to be overriden where this
     * value is lower.
     * Useful when a shipping service has a global weight limit you do not wish
     * to exceed.
     * @var float
     */
    protected $maxCubic = null;

    /**
     * Allows the maximum gross weight for the boxes to be overriden where this
     * value is lower.
     * @var float
     */
    protected $maxWeight = null;

    /**
     * Allows us to make intelligent decisions about conversions on weights
     * @var float
     */
    protected $weightType = 'g';

    /**
     * Used to hold array of items provided by the calling code once they are
     * converted to model\item objects
     * @var array
     */
    protected $items = array();

    /**
     * Used to hold array of boxes provided by the calling code once they are
     * converted to model\box objects
     * @var array
     */
    protected $boxes = array();

    /**
     * Constructor class, sets initial class state
     * @param  array  $items      Objects to pack
     * @param  array  $boxes      Boxes to pack into
     * @param  float  $maxCubic   Upper ceiling for box Cubic Weight (Optional)
     * @param  float  $maxWeight  Upper ceiling for box Gross Weight (Optional)
     * @param  string $weightType Used for determining upper ceiling (Optional)
     */
    public function _construct(
        array $items,
        array $boxes,
        float $maxCubic = null,
        float $maxWeight = null,
        string $weightType = null
    )
    {
        if(!empty($maxCubic)){
            $this->maxCubic = $maxCubic;
        }

        if(!empty($maxWeight)){
            $this->maxWeight = $maxWeight;
        }

        if(!empty($weightType)){
            $this->weightType = $weightType;
        }
    }
}
