<?php

namespace App\Services;

use App\Utils\CSVWriter;
use Exception;
use League\Csv\CannotInsertRecord;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class ReportingService implements ReportingServiceInterface
{
  private ContainerInterface $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * @inheritDoc
   */
  public function generateCsvReport(string $fileName, array $headers, array $records): string
  {
    try {
      CSVWriter::write(
        $this->convertRecordsToArray($records),
        $this->getFilePath($fileName),
        $headers
      );
    } catch (CannotInsertRecord $e) {
      throw new Exception($e->getMessage());
    }

    return $fileName;
  }

  private function convertRecordsToArray(array $records): array
  {
    return array_map(function ($record) {
      return $record->__toArray();
    }, $records);
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
      return '/../../reports/' . $fileName;
    }
  }
}