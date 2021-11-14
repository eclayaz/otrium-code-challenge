<?php
declare(strict_types=1);

namespace App\Exceptions;

class HttpException extends \DomainException
{
  public const STATUS_CODE_LIMIT = 600;
  public const STATUS_BAD_REQUEST = 400;

  /**
   * @param string          $message
   * @param string          $description
   * @param int             $code
   * @param int             $statusCode
   * @param \Throwable|null $previous
   * @throws \RuntimeException
   */
  public function __construct(
    string $message,
    string $description,
    int $code,
    int $statusCode,
    \Throwable $previous = null
  ) {
    if ($statusCode < static::STATUS_BAD_REQUEST || $statusCode >= static::STATUS_CODE_LIMIT) {
      throw new \RuntimeException(\sprintf('%s is not a valid HTTP error status code', $statusCode));
    }

    parent::__construct(\trim($message), $code, $previous);
  }
}