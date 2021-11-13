<?php

use App\FooInterface;
use App\Foo;
use App\Repositories\GrossMerchandiseValueRepository;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Services\ReportingService;
use App\Services\ReportingServiceInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;

return [
  'connection' => [
    'dbname' => DI\env('DATABASE_NAME', 'otrium'),
    'user' => DI\env('DATABASE_USER', 'dev'),
    'password' => DI\env('DATABASE_PASSWORD', 'dev'),
    'host' => 'mysqldb',
    'driver' => 'pdo_mysql',
  ],
  'report_store' => __DIR__ . '/../../reports',
  'vat_percentage' => .21,


  // Database
  Connection::class => function (ContainerInterface $c) {
    return DriverManager::getConnection($c->get('connection'));
  },

  // Bind an interface to an implementation
  GrossMerchandiseValueRepositoryInterface::class => DI\autowire(GrossMerchandiseValueRepository::class),
  ReportingServiceInterface::class => DI\autowire(ReportingService::class),
  FooInterface::class => DI\autowire(Foo::class),
];
