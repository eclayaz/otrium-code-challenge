<?php

namespace App\Repositories;

use App\DTOs\TurnoverPerBrand;
use App\DTOs\TurnoverPerDay;
use App\Repositories\Entities\GMV;

final class GrossMerchandiseValueRepository extends BaseRepository implements GrossMerchandiseValueRepositoryInterface
{
  /**
   * @inheritDoc
   */
  public function getTurnoverPerBrand(string $startDate, string $endDate, float $vat): array
  {
    $queryBuilder = $this->entityManager->createQueryBuilder()
      ->select(sprintf(
        'NEW %s(gmv.date, b.name, SUM(gmv.turnover * :vat))',
        TurnoverPerBrand::class
      ))
      ->from(GMV::class, 'gmv')
      ->join('gmv.brand', 'b')
      ->where('gmv.date BETWEEN :start AND :end')
      ->groupBy('b.name')
      ->addGroupBy('gmv.date')
      ->orderBy('gmv.date')
      ->setParameter('start', $startDate)
      ->setParameter('end', $endDate)
      ->setParameter('vat', 1 - $vat);

    return $this->findRecords($queryBuilder);
  }

  /**
   * @inheritDoc
   */
  public function getTurnoverPerDay(string $startDate, string $endDate, float $vat): array
  {
    $queryBuilder = $this->entityManager->createQueryBuilder()
      ->select(sprintf(
        'NEW %s(gmv.date, SUM(gmv.turnover * :vat))',
        TurnoverPerDay::class
      ))
      ->from(GMV::class, 'gmv')
      ->where('gmv.date BETWEEN :start AND :end')
      ->groupBy('gmv.date')
      ->orderBy('gmv.date')
      ->setParameter('start', $startDate)
      ->setParameter('end', $endDate)
      ->setParameter('vat', 1 - $vat);

    return $this->findRecords($queryBuilder);
  }
}