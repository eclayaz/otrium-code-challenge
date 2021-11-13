<?php

namespace App\Services;

use App\Exceptions\NotFoundHttpException;
use Exception;
use InvalidArgumentException;

interface ReportingServiceInterface
{
  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   * @throws Exception
   * @throws InvalidArgumentException
   * @throws NotFoundHttpException
   */
  public function createTurnoverPerBrandReport(string $startDate, int $duration): string;

  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   * @throws Exception
   * @throws InvalidArgumentException
   * @throws NotFoundHttpException
   */
  public function createTurnoverPerDayReport(string $startDate, int $duration): string;
}