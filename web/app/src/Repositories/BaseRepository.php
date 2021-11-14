<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

abstract class BaseRepository implements BaseRepositoryInterface
{
  protected EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $connection)
  {
    $this->entityManager = $connection;
  }

  /**
   * @param QueryBuilder $queryBuilder
   * @return array
   * @throws NotFoundHttpException
   */
  public function findRecords(QueryBuilder $queryBuilder): array
  {
    $result = $queryBuilder->getQuery()
      ->getResult();

    if (count($result) === 0) {
      throw new NotFoundHttpException('Could not find matching records');
    }

    return $result;
  }
}