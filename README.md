Iridium-components-config
=======================================

[![Build Status](https://travis-ci.org/awakenweb/Iridium-components-config.png?branch=master)](https://travis-ci.org/awakenweb/Iridium-components-config)

Simple Configuration files loading and manipulation for Iridium Framework. Works as a standalone library but best used with the full stack framework.

This component allows you to parse multiple configuration files and searching for configuration values inside them using a path syntax.
Each configuration file is stored in a separate namespace to avoid collisions between files.
Loaders for Yaml and Json files are provided, but you can extend the library to handle any file format you want.


The class is unit tested using [Atoum](https://github.com/atoum/atoum).

Installation
------------
### Prerequisites

***Iridium requires at least PHP 5.4+ to work.***

Some of Iridium components may work on PHP5.3 but this feature is not intended and no support will be provided for version before 5.4.

### Using Composer
First, install [Composer](http://getcomposer.org/ "Composer").
Create a composer.json file at the root of your project. This file must at least contain :
```json
{
    "require": {
        "awakenweb/iridium-components-config": "dev-master"
        }
}
```
and then run
```bash
~$ composer install
```
---
Usage
-----

To initialize the configuration manager, you have to follow these steps:

### Instanciate File loaders, LoaderResolver and Loader
You can initialize different loaders that will be called one after each other, until one is able to handle the configuration file.

```php
<?php

include(path/to/vendor/autoload.php);
use Iridium\Components\Config\Loaders;

$loader1 = new Loaders\Yaml();
$loader2 = new Loaders\Json();

```

You now have to pass these loaders to the `Config\LoaderResolver`. This class is used by the loading class to determine which file loader to use.

```php
<?php
use Iridium\Components\Config;
$loaderresolver = new Config\LoaderResolver(array($loader1, $loader2));
$loader = new Config\Loader($loaderresolver);

```

### Manager

You can now initialize the `Config\Manager` class by passing it the `Config\Loader`.
Use the `load` method of the manager to define a file to parse and use it. The second parameter to the `load` method is the namespace you want your configuration values stored into.

```php
<?php 

use Iridium\Components\Config;

$manager = new Config\Manager($loader);
$manager->load('/path/to/config/file/webservices.yml', 'webservices')
        ->load('/path/to/anotherfile/somefile.json', 'database');

// by default, the namespace delimiter is the '.' (dot) character
$username = $manager->get('webservices.twitter.authentication.username');

// you can define a different delimiter if you want to
$host = $manager->get('database@mysql@host', '@');
```