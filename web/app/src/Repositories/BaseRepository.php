<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;

abstract class BaseRepository implements BaseRepositoryInterface
{
  protected Connection $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }


  public function find(Statement $statement): array
  {
    $resultSet = $statement->executeQuery();
    $data = $resultSet->fetchAllAssociative();

    if (count($data) === 0) {
      throw new NotFoundHttpException('Could not find matching records');
    }

    return $data;
  }
}