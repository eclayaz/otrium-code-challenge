<?php

namespace AppTest;

use App\Foo;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
  protected mixed $container;

  protected function setUp(): void
  {
    parent::setUp();
    $this->container = require __DIR__ . '/../bootstrap/autoload.php';
    $this->container->injectOn($this);
  }

    public function testGetName()
    {
      $foo = $this->container->get('Foo');
        $this->assertEquals('Nginx PHP MySQL', 'Nginx PHP MySQL');
    }
}
