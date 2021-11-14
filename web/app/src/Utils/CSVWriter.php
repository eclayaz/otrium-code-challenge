<?php

namespace App\Utils;

use InvalidArgumentException;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Webmozart\Assert\Assert;

final class CSVWriter
{
  /**
   * @param array $data
   * @param string $filePath
   * @param array $headers
   * @throws InvalidArgumentException
   * @throws CannotInsertRecord
   */
  public static function write(array $data, string $filePath, array $headers): void
  {
    Assert::notEmpty($data);
    Assert::notEmpty($filePath);
    Assert::notEmpty($headers);

    $writer = Writer::createFromPath($filePath . '', 'w+');
    $writer->insertOne($headers);
    $writer->insertAll($data);
  }
}