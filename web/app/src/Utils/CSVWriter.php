<?php

namespace App\Utils;

use ArrayIterator;
use InvalidArgumentException;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Webmozart\Assert\Assert;

class CSVWriter
{
  private array $data;
  private string $filePath;
  private array $headers;

  /**
   * @param array $data
   * @param string $filePath
   * @param array $headers
   * @throws InvalidArgumentException
   */
  public function __construct(array $data, string $filePath, array $headers)
  {
    Assert::notEmpty($data);
    Assert::notEmpty($filePath);
    Assert::notEmpty($headers);

    $this->data = $data;
    $this->filePath = $filePath;
    $this->headers = $headers;
  }

  /**
   * @throws CannotInsertRecord
   */
  public function write(): void
  {
    $writer = Writer::createFromPath($this->filePath . '', 'w+');
    $writer->insertOne($this->headers);
    $writer->insertAll($this->data);
  }
}