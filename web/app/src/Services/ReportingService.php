<?php

namespace App\Services;

use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Utils\CSVWriter;
use Carbon\Carbon;
use League\Csv\CannotInsertRecord;
use Psr\Container\ContainerInterface;

class ReportingService implements ReportingServiceInterface
{
  private GrossMerchandiseValueRepositoryInterface $gmvRepository;
  private ContainerInterface $container;

  public function __construct(GrossMerchandiseValueRepositoryInterface $gmvRepository, ContainerInterface $container)
  {
    $this->gmvRepository = $gmvRepository;
    $this->container = $container;
  }

  /**
   * @inheritdoc
   */
  public function createTurnoverPerBrandReport(string $startDate, int $duration): string
  {
    try {
      $data = $this->gmvRepository->getSevenDayTurnoverPerBrand(
        $startDate,
        $this->getEndDateByDuration($startDate, $duration),
        $this->container->get('vat_percentage')
      );
    } catch (\Doctrine\DBAL\Driver\Exception | \Doctrine\DBAL\Exception $e) {
      throw new \Exception($e->getMessage());
    }

    try {
      $fileName = '7-days-turnover-per-brand-' . $startDate . '.csv';
      (new CSVWriter($data, $this->getFilePath($fileName), ['Day', 'Brand Name', 'Turnover Excluding Vat']))->write();
    } catch (CannotInsertRecord $e) {
      throw new \Exception($e->getMessage());
    }

    return $fileName;
  }

  /**
   * @inheritdoc
   */
  public function createTurnoverPerDayReport(string $startDate, int $duration): string
  {
    try {
      $data = $this->gmvRepository->getSevenDayTurnoverPerDay(
        $startDate,
        $this->getEndDateByDuration($startDate, $duration),
        $this->getVatPercentage()
      );
    } catch (\Doctrine\DBAL\Driver\Exception | \Doctrine\DBAL\Exception $e) {
      throw new \Exception($e->getMessage());
    }

    try {
      $fileName = '7-days-turnover-per-day-' . $startDate . '.csv';
      (new CSVWriter($data, $this->getFilePath($fileName), ['Day', 'Turnover Excluding Vat']))->write();
    } catch (CannotInsertRecord $e) {
      throw new \Exception($e->getMessage());
    }

    return $fileName;
  }

  /**
   * @param string $fileName
   * @return string
   */
  private function getFilePath(string $fileName): string
  {
    return $this->container->get('report_store') . '/' . $fileName;
  }

  /**
   * @return float
   */
  private function getVatPercentage(): float
  {
    return $this->container->get('vat_percentage');
  }

  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   */
  private function getEndDateByDuration(string $startDate, int $duration): string
  {
    return Carbon::parse($startDate)->addDays($duration)->toDateString();
  }
}