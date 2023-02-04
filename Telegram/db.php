<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([

    'driver'   => 'mysql',

    'host'     => 'localhost',

    'database' => 'telegram',

    'username' => 'root',

    'password' => '',

    'charset'   => 'utf8',

    'collation' => 'utf8_unicode_ci',

    'prefix'   => '',

]);

$capsule->setAsGlobal();

$capsule->bootEloquent();