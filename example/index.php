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
    'weight' => 2000
  ),
  array(
    'name' =>'bats',
    'length' => 100,
    'width' => 500,
    'height' => 150,
    'weight' => 2500
  ),
  array(
    'name' =>'cats',
    'length' => 150,
    'width' => 506,
    'height' => 205,
    'weight' => 2100
  ),array(
    'name' =>'rats',
    'length' => 100,
    'width' => 50,
    'height' => 20,
    'weight' => 1000
  ),array(
    'name' =>'gnats',
    'length' => 10,
    'width' => 5,
    'height' => 20,
    'weight' => 200
  ),
);
$boxes = array(
  array(
    'name' =>'box1',
    'length' => 20,
    'width' => 60,
    'height' => 250,
    'weight' => 2500
  ),
  array(
    'name' =>'box2',
    'length' => 150,
    'width' => 600,
    'height' => 300,
    'weight' => 7900000
  ),
  array(
    'name' =>'box3',
    'length' => 20,
    'width' => 60,
    'height' => 250,
    'weight' => 2500
  )
);

$knapper = new knapper($items, $boxes);
$results = $knapper->pack();

print_r($results);

 ?>
