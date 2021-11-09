<?php


use App\Acme\FooInterface;
use App\Acme\Mailer;
use App\Acme\UserManager;
use App\Acme\Foo;

return [
  // Bind an interface to an implementation
  Mailer::class => DI\autowire(Mailer::class),
  UserManager::class => DI\autowire(UserManager::class),
  FooInterface::class => DI\autowire(Foo::class),
];
