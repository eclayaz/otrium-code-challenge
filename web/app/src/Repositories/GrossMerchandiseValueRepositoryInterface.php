<?php

namespace App\Repositories;

use App\Exceptions\NotFoundHttpException;

interface GrossMerchandiseValueRepositoryInterface
{
  /**
   * @param string $startDate
   * @param string $endDate
   * @param float $vat
   * @return array
   * @throws \Doctrine\DBAL\Exception
   * @throws \Doctrine\DBAL\Driver\Exception
   * @throws NotFoundHttpException
   */
  public function getSevenDayTurnoverPerBrand(string $startDate, string $endDate, float $vat): array;

  /**
   * @param string $startDate
   * @param string $endDate
   * @param float $vat
   * @return array
   * @throws \Doctrine\DBAL\Exception
   * @throws \Doctrine\DBAL\Driver\Exception
   * @throws NotFoundHttpException
   */
  public function getSevenDayTurnoverPerDay(string $startDate, string $endDate, float $vat): array;
}