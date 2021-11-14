<?php

namespace App\Controllers;

use App\Exceptions\NotFoundHttpException;
use App\Services\TurnoverReportingServiceInterface;
use Exception;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class ReportingController extends BaseController
{
  private TurnoverReportingServiceInterface $reportingService;

  public function __construct(TurnoverReportingServiceInterface $reportingService)
  {
    $this->reportingService = $reportingService;
  }

  public function __invoke(array $params)
  {
    header('Content-Type: application/json; charset=utf-8');

    $startDate = $params['startDate'] ?? null;
    try {
      Assert::notEmpty($startDate);
    } catch ( InvalidArgumentException $exception) {
      $errors['startDate'] = 'Start date is required.';
      $this->failResponse('Invalid data', $errors);
      return;
    }

    $duration = 6;
    $reports = [];

    try {
      $reports['turnoverPerBrandReport'] = $this->reportingService->generateTurnoverPerBrandReport($startDate, $duration);
      $reports['turnoverPerDayReport'] = $this->reportingService->generateTurnoverPerDayReport($startDate, $duration);
    } catch (NotFoundHttpException | Exception $e) {
      $this->failResponse($e->getMessage());
      return;
    }

    $this->successResponse($reports);
  }
}