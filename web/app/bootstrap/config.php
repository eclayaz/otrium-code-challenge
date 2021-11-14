<?php

use App\FooInterface;
use App\Foo;
use App\Repositories\GrossMerchandiseValueRepository;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Services\TurnoverTurnoverReportingService;
use App\Services\TurnoverReportingServiceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\Tools\Setup;

return [
  'connection' => [
    'dbname' => DI\env('DATABASE_NAME', 'otrium'),
    'user' => DI\env('DATABASE_USER', 'dev'),
    'password' => DI\env('DATABASE_PASSWORD', 'dev'),
    'host' => 'mysqldb',
    'driver' => 'pdo_mysql',
  ],
  'report_store' => __DIR__ . '/../../reports',
  'vat_percentage' => 0.21,

  EntityManagerInterface::class => function (ContainerInterface $c){
    $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../src/Entities'], true);
    return EntityManager::create($c->get('connection'), $config);
  },

  // Bind an interface to an implementation
  GrossMerchandiseValueRepositoryInterface::class => DI\autowire(GrossMerchandiseValueRepository::class),
  TurnoverReportingServiceInterface::class => DI\autowire(TurnoverTurnoverReportingService::class),
  FooInterface::class => DI\autowire(Foo::class),
];
