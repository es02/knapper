# Knapper

Simple, dependency-free knapsack solver

Master: [![Build Status: Master](https://travis-ci.com/es02/knapper.svg?branch=master)](https://travis-ci.com/es02/knapper)

Dev: [![Build Status: Dev](https://travis-ci.com/es02/knapper.svg?branch=dev)](https://travis-ci.com/es02/knapper)

## Getting Started

These instructions will get you a copy of the project installed in your composer dependencies.

### Prerequisites

PHP 7

### Installing

Adding knapper to your project is as simple as adding it to your composer.json

```
composer require es02/knapper
```

### Usage

```
$knapper = new Knapper($items, $boxes);
$results = $knapper->pack();
```

To use Knappper you will need an array of objects to be packed and an array of boxes to pack them into.
Optionally you can supply the following fields:

* maxCubic (Default: null) - Set an upper limit on cubic weight for boxes
* maxWeight (Default: null) - set an upper limit on physical weight for boxes
* weightType (Options: 'g', 'kg', 'oz', 'lb') (Default: 'g')  - Choose metric or imperial measurements for that weight

Some carriers require boxes in a shipment to remain below certain cubic/gross weight limits.
These options allow you to achieve this with minimal effort.

```
$knapper = new Knapper($items, $boxes, 15, 15 , 'kg');
$results = $knapper->pack();
```

Both arrays require the following fields:

* length
* width
* height
* weight

```
$items[] = array('length' => 10, 'width' => 50, 'height' => 200, 'weight' => 2);
$boxes[] = array('length' => 20, 'width' => 60, 'height' => 250, 'weight' => 2.5);
```

In addition both support the following optional fields:

* name (Default: null) - Allows you to set a human readable name for your item/box
* lengthType (Options: 'cm', 'm', 'in', 'ft') (Default: 'cm') - Sets measurement type
* weightType (Options: 'g', 'kg', 'oz', 'lb') (Default: 'g') - Sets measurement type

Boxes can have the following optional fields
* quantity  (Default: 0) - Sets whether or not a box size has a limited supply, leave at 0 for unlimited

Items can have the following optional fields
* thisWayUp  (Default: false) - Sets whether or not the item can be placed on it's side

*Where not manually set, optional fields will use their default values*

```
$items[] = array(
    'name' => "Sculpture"
    'length' => 10,
    'width' => 50,
    'height' => 200,
    'weight' => 2,
    'lengthType' => 'in',
    'weightType' => 'lb',
    'thisWayUp' => false
);
$boxes[] = array(
    'name' => "Large Packing Box",
    'length' => 20,
    'width' => 60,
    'height' => 250,
    'weight' => 2.5,
    'lengthType' => 'in',
    'weightType' => 'lb',
    'quantity' => 20
);
```

## Contributing

Please read [CONTRIBUTING.md]() for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/es02/knapper/tags).

## Authors

* **Tom Hobson** - *Initial work* - [ArachnidsGrip](https://github.com/es02)

## License

This project is licensed under the GNU GPL - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* ReadMe template from [PurpleBooth](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2)
* Changelog Template from [KeepAChangelog](https://keepachangelog.com/en/1.0.0/)
* Contributing template from [PurpleBooth](https://gist.github.com/PurpleBooth/b24679402957c63ec426)
