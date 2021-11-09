<?php

use App\Acme\Foo;

$container = require __DIR__ . '/../app/bootstrap/autoload.php';

$foo = $container->get(Foo::class);
$foo->getName();
