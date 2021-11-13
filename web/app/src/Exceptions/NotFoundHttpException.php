<?php
declare(strict_types=1);

namespace App\Exceptions;

/**
 * HTTP 404 Not Found exception class.
 */
class NotFoundHttpException extends HttpException
{
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
      $code ?? StatusCodeInterface::STATUS_NOT_FOUND,
      StatusCodeInterface::STATUS_NOT_FOUND,
      $previous
    );
  }
}