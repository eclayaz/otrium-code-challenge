<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;

interface BaseRepositoryInterface
{
  /**
   * @param Statement $statement
   * @return array
   * @throws NotFoundHttpException
   * @throws DBALDriverException
   * @throws Exception
   */
   public function find(Statement $statement): array;
}