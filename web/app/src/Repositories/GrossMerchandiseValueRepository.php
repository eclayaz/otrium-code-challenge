<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;

class GrossMerchandiseValueRepository implements GrossMerchandiseValueRepositoryInterface
{
  private Connection $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  public function getSevenDayTurnoverPerBrand(string $startDate, string $endDate, float $vat): array
  {
    $sql = "
            select date as 'day', b.name as 'brand_name', sum(turnover * :vat_deduction) as 'turnover_excluding_vat'
            from gmv
            join brands b on b.id = gmv.brand_id
            where (date between :start and :end)
            group by name, date
            order by date
            ";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':start', $startDate);
    $stmt->bindValue(':end', $endDate);
    $stmt->bindValue(':vat_deduction', 1 - $vat);

    return $this->findOrFail($stmt);
  }

  public function getSevenDayTurnoverPerDay(string $startDate, string $endDate, float $vat): array
  {
    $sql = "
            select date as 'day', sum(turnover * :vat_deduction) as 'turnover_excluding_vat'
            from gmv
                     join brands b on b.id = gmv.brand_id
            WHERE (date BETWEEN :start AND :end)
            group by date
            order by date
            ";

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':start', $startDate);
    $stmt->bindValue(':end', $endDate);
    $stmt->bindValue(':vat_deduction', 1 - $vat);

    return $this->findOrFail($stmt);
  }

  /**
   * @param Statement $stmt
   * @return array
   * @throws DBALDriverException
   * @throws Exception
   * @throws NotFoundHttpException
   */
  private function findOrFail(Statement $stmt): array
  {
    $resultSet = $stmt->executeQuery();
    $data = $resultSet->fetchAllAssociative();

    if (count($data) === 0) {
      throw new NotFoundHttpException('No data found for given time period');
    }

    return $data;
  }
}