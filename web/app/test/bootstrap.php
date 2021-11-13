<?php

error_reporting(E_ALL | E_STRICT);

/**
 * Setup autoloading
 */
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

return (new ContainerBuilder)
  ->addDefinitions(__DIR__ . '../bootstrap/config.php')
  ->build();
