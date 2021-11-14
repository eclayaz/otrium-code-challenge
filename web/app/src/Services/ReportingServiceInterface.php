<?php

namespace App\Services;

use Exception;

interface ReportingServiceInterface
{
  /**
   * @param string $fileName
   * @param array $headers
   * @param array $records
   * @return string
   * @throws Exception
   */
  public function generateCsvReport(string $fileName, array $headers, array $records): string;
}