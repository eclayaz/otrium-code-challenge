<?php

namespace App\DTOs;

use DateTime;

final class TurnoverPerBrand
{
  private DateTime $day;

  private string $brandName;

  private float $turnoverWithoutVat;

  public function __construct(DateTime $day, string $brandName, float $turnoverWithoutVat)
  {
    $this->day = $day;
    $this->brandName = $brandName;
    $this->turnoverWithoutVat = $turnoverWithoutVat;
  }

  public function getDay(): DateTime
  {
    return $this->day;
  }

  public function getBrandName(): string
  {
    return $this->brandName;
  }

  public function getTurnoverWithoutVat(): float
  {
    return $this->turnoverWithoutVat;
  }

  public function __toArray(): array
  {
    return [
      'day' => $this->day->format('Y-m-d'),
      'brandName' => $this->brandName,
      'turnoverWithoutVat' => $this->turnoverWithoutVat
    ];
  }
}