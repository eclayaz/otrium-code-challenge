<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;
use Doctrine\ORM\QueryBuilder;

interface BaseRepositoryInterface
{
  /**
   * @param QueryBuilder $queryBuilder
   * @return array
   * @throws NotFoundHttpException
   */
   public function findRecords(QueryBuilder $queryBuilder): array;
}