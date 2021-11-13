<?php
declare(strict_types=1);

namespace App\Exceptions;

class HttpException extends \DomainException
{
  const STATUS_CODE_LIMIT = 600;

  /**
   * @param string          $message
   * @param string          $description
   * @param int             $code
   * @param int             $statusCode
   * @param \Throwable|null $previous
   *
   * @throws \RuntimeException
   */
  public function __construct(
    string $message,
    string $description,
    int $code,
    int $statusCode,
    \Throwable $previous = null
  ) {
    if ($statusCode < StatusCodeInterface::STATUS_BAD_REQUEST || $statusCode >= static::STATUS_CODE_LIMIT) {
      throw new \RuntimeException(\sprintf('%s is not a valid HTTP error status code', $statusCode));
    }

    parent::__construct(\trim($message), $code, $previous);
  }
}