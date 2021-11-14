<?php

namespace App\Controllers;

use App\Exceptions\NotFoundHttpException;
use App\Services\TurnoverReportingServiceInterface;
use Exception;

final class ReportingController
{
  private TurnoverReportingServiceInterface $reportingService;

  public function __construct(TurnoverReportingServiceInterface $reportingService)
  {
    $this->reportingService = $reportingService;
  }

  public function __invoke(array $params)
  {
    $startDate = $params['startDate'];
    $errors = [];
    if (empty($startDate)) {
      $errors['startDate'] = 'Start date is required.';
    }

    if (!empty($errors)) {
      $this->fail('Validation fail!', $errors);
      return;
    }

    $duration = 6;
    $reports = [];

    try {
      $reports['turnoverPerBrandReport'] = $this->reportingService->generateTurnoverPerBrandReport($startDate, $duration);
      $reports['turnoverPerDayReport'] = $this->reportingService->generateTurnoverPerDayReport($startDate, $duration);
    } catch (NotFoundHttpException | Exception $e) {
      $this->fail($e->getMessage());
      return;
    }

    $this->success($reports);
  }

  /**
   * @param string $message
   * @param array $errors
   */
  private function fail(string $message, array $errors = []): void
  {
    $data['success'] = false;
    $data['message'] = $message;
    $data['errors'] = $errors;
    echo json_encode($data);
  }


  /**
   * @param $responseData
   */
  private function success($responseData): void
  {
    $data['success'] = true;
    $data['message'] = 'Success!';
    $data['errors'] = [];
    $data['responseData'] = $responseData;
    echo json_encode($data);
  }
}