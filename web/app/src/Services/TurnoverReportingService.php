<?php

namespace App\Services;

use App\Exceptions\NotFoundHttpException;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class TurnoverReportingService extends ReportingService implements TurnoverReportingServiceInterface
{
  private GrossMerchandiseValueRepositoryInterface $gmvRepository;

  private ContainerInterface $container;

  public function __construct(GrossMerchandiseValueRepositoryInterface $gmvRepository, ContainerInterface $container)
  {
    parent::__construct($container);
    $this->gmvRepository = $gmvRepository;
    $this->container = $container;
  }

  /**
   * @inheritdoc
   */
  public function generateTurnoverPerBrandReport(string $startDate, int $duration): string
  {
    try {
      $data = $this->gmvRepository->getTurnoverPerBrand(
        $startDate,
        $this->getEndDate($startDate, $duration),
        $this->container->get('vat_percentage')
      );
      $fileName = '7-days-turnover-per-brand-' . $startDate . '.csv';
      $headers = ['Day', 'Brand Name', 'Turnover Without Vat'];
      return $this->generateCsvReport($fileName, $headers, $data);
    } catch (NotFoundHttpException $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * @inheritdoc
   */
  public function generateTurnoverPerDayReport(string $startDate, int $duration): string
  {
    try {
      $data = $this->gmvRepository->getTurnoverPerDay(
        $startDate,
        $this->getEndDate($startDate, $duration),
        $this->getVatPercentage()
      );
      $fileName = '7-days-turnover-per-day-' . $startDate . '.csv';
      $headers = ['Day', 'Turnover Without Vat'];
      return $this->generateCsvReport($fileName, $headers, $data);
    } catch (\Doctrine\DBAL\Driver\Exception | \Doctrine\DBAL\Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   */
  private function getEndDate(string $startDate, int $duration): string
  {
    return Carbon::parse($startDate)->addDays($duration)->toDateString();
  }

  /**
   * @return float
   */
  private function getVatPercentage(): float
  {
    try {
      return $this->container->get('vat_percentage');
    } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
      return 0.21;
    }
  }
}