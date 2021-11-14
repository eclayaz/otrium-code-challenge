<?php

namespace App\Services;

use App\Exceptions\NotFoundHttpException;
use Exception;
use InvalidArgumentException;

interface TurnoverReportingServiceInterface
{
  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   * @throws Exception
   * @throws InvalidArgumentException
   * @throws NotFoundHttpException
   */
  public function generateTurnoverPerBrandReport(string $startDate, int $duration): string;

  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   * @throws Exception
   * @throws InvalidArgumentException
   * @throws NotFoundHttpException
   */
  public function generateTurnoverPerDayReport(string $startDate, int $duration): string;
}