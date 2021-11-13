<?php

namespace AppTest;

use DI\Container;
use DI\ContainerBuilder;

class TestCase extends \PHPUnit\Framework\TestCase
{
  protected $container;

  protected function setUp(): void
  {
    $this->container = require __DIR__ . '/../bootstrap/autoload.php';
    $this->container->injectOn($this);
    parent::setUp();
  }
}