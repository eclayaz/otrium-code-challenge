<?php

namespace App\Repositories;

use App\DTOs\Brand;
use App\Exceptions\NotFoundHttpException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManager;

final class GrossMerchandiseValueRepository extends BaseRepository implements GrossMerchandiseValueRepositoryInterface
{
  public function getSevenDayTurnoverPerBrand(string $startDate, string $endDate, float $vat): array
  {
    $query = "
            select date as 'day', b.name as 'brand_name', sum(turnover * :vat_deduction) as 'turnover_excluding_vat'
            from gmv
            join brands b on b.id = gmv.brand_id
            where (date between :start and :end)
            group by name, date
            order by date
            ";

    $statement = $this->connection->prepare($query);
    $statement->bindValue(':start', $startDate);
    $statement->bindValue(':end', $endDate);
    $statement->bindValue(':vat_deduction', 1 - $vat);

    return $this->find($statement);
  }

  public function getSevenDayTurnoverPerDay(string $startDate, string $endDate, float $vat): array
  {
    $query = "
            select date as 'day', sum(turnover * :vat_deduction) as 'turnover_excluding_vat'
            from gmv
                     join brands b on b.id = gmv.brand_id
            WHERE (date BETWEEN :start AND :end)
            group by date
            order by date
            ";

    $statement = $this->connection->prepare($query);
    $statement->bindValue(':start', $startDate);
    $statement->bindValue(':end', $endDate);
    $statement->bindValue(':vat_deduction', 1 - $vat);

    return $this->find($statement);
  }

  public function findX(): array
  {
    /* @var $entityManager EntityManager */
    $entityManager = $this->getDoctrine()->getManager();

    $result = $entityManager->createQueryBuilder()
      ->from(Brand::class, 'u')
      ->getQuery()
      ->getResult();

    var_dump($result);
    die('uu');
  }
}