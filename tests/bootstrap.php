<?php

namespace OpenClassrooms\Tests;

use Composer\Autoload\ClassLoader;

error_reporting(E_ALL | E_STRICT);

/** @var ClassLoader$loader */
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('OpenClassrooms\\Tests\\', __DIR__ );
