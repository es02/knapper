<?php
namespace es02\example;

include "../vendor/autoload.php";

use es02\knapper\Knapper;

/**
 *
 * Obviously you would place items and boxes
 * in some kind of database and not hard code them like this
 *
 **/

$items = array(
  array(
    'name' =>'hats',
    'length' => 10,
    'width' => 50,
    'height' => 200,
    'weight' => 2
  ),
  array(
    'name' =>'bats',
    'length' => 100,
    'width' => 500,
    'height' => 150,
    'weight' => 2.5
  ),
  array(
    'name' =>'cats',
    'length' => 150,
    'width' => 506,
    'height' => 205,
    'weight' => 2.1
  ),array(
    'name' =>'rats',
    'length' => 100,
    'width' => 50,
    'height' => 20,
    'weight' => 1
  ),array(
    'name' =>'gnats',
    'length' => 10,
    'width' => 5,
    'height' => 20,
    'weight' => 0.2
  ),
);
$boxes = array(
  array(
    'name' =>'',
    'length' => 20,
    'width' => 60,
    'height' => 250,
    'weight' => 2.5
  ),
  array(
    'name' =>'',
    'length' => 150,
    'width' => 600,
    'height' => 300,
    'weight' => 3
  ),
  array(
    'name' =>'',
    'length' => 20,
    'width' => 60,
    'height' => 250,
    'weight' => 2.5
  )
);

$knapper = new knapper($items, $boxes);
$results = $knapper->pack();

print_r($results);

 ?>