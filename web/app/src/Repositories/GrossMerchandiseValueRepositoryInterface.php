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
   * @throws NotFoundHttpException
   */
  public function getTurnoverPerBrand(string $startDate, string $endDate, float $vat): array;

  /**
   * @param string $startDate
   * @param string $endDate
   * @param float $vat
   * @return array
   * @throws NotFoundHttpException
   */
  public function getTurnoverPerDay(string $startDate, string $endDate, float $vat): array;
}