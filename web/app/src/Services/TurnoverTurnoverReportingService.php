<?php

namespace App\Services;

use App\Exceptions\NotFoundHttpException;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Utils\CSVWriter;
use Carbon\Carbon;
use League\Csv\CannotInsertRecord;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class TurnoverTurnoverReportingService implements TurnoverReportingServiceInterface
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
  public function generateTurnoverPerBrandReport(string $startDate, int $duration): string
  {
    try {
      $data = $this->gmvRepository->getTurnoverPerBrand(
        $startDate,
        $this->getEndDate($startDate, $duration),
        $this->container->get('vat_percentage')
      );
    } catch (NotFoundHttpException $e) {
      throw new \Exception($e->getMessage());
    }

    try {
      $fileName = '7-days-turnover-per-brand-' . $startDate . '.csv';
      (new CSVWriter(
        $this->convertRecordsArray($data),
        $this->getFilePath($fileName),
        ['Day', 'Brand Name', 'Turnover Excluding Vat'])
      )->write();
    } catch (CannotInsertRecord $e) {
      throw new \Exception($e->getMessage());
    }

    return $fileName;
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
    } catch (\Doctrine\DBAL\Driver\Exception | \Doctrine\DBAL\Exception $e) {
      throw new \Exception($e->getMessage());
    }

    try {
      $fileName = '7-days-turnover-per-day-' . $startDate . '.csv';
      (new CSVWriter(
        $this->convertRecordsArray($data),
        $this->getFilePath($fileName),
        ['Day', 'Turnover Excluding Vat'])
      )->write();
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
    try {
      return $this->container->get('report_store') . '/' . $fileName;
    } catch (NotFoundExceptionInterface | ContainerExceptionInterface $e) {
      return  '/../../reports/' . $fileName;
    }
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

  /**
   * @param string $startDate
   * @param int $duration
   * @return string
   */
  private function getEndDate(string $startDate, int $duration): string
  {
    return Carbon::parse($startDate)->addDays($duration)->toDateString();
  }

  private function convertRecordsArray(array $records): array
  {
    return array_map(function ($record) {
      return $record->__toArray();
    }, $records);
  }
}