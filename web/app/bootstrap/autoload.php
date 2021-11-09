<?php

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

return (new ContainerBuilder)
  ->addDefinitions(__DIR__ . '/config.php')
  ->build();