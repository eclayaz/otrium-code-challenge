<?php

namespace AppTest;

use App\Foo;
use DI\ContainerBuilder;

class FooTest extends TestCase
{
    public function testGetName()
    {
      $foo = $this->container->get(Foo::class);
      $this->assertEquals($foo->getName(), 'Nginx PHP MySQL');
    }
}
