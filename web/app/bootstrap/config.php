<?php


use App\FooInterface;
use App\HomeController;
use App\Mailer;
use App\UserManager;
use App\Foo;

return [
  // Bind an interface to an implementation
  Mailer::class => DI\autowire(Mailer::class),
  UserManager::class => DI\autowire(UserManager::class),
  FooInterface::class => DI\autowire(Foo::class),
  HomeController::class => DI\autowire(HomeController::class),
];
