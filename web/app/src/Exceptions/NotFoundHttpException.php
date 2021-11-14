<?php
declare(strict_types=1);

namespace App\Exceptions;

/**
 * HTTP 404 Not Found exception class.
 */
final class NotFoundHttpException extends HttpException
{
  public const STATUS_NOT_FOUND = 404;

  /**
   * @param string|null     $message
   * @param string|null     $description
   * @param int|null        $code
   * @param \Throwable|null $previous
   */
  public function __construct(
    string $message = null,
    string $description = null,
    int $code = null,
    \Throwable $previous = null
  ) {
    parent::__construct(
      $message ?? 'Not Found',
      $description ?? '',
      $code ?? self::STATUS_NOT_FOUND,
      self::STATUS_NOT_FOUND,
      $previous
    );
  }
}