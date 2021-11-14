<?php

namespace App\DTOs;

use DateTime;

final class TurnoverPerDay
{
  private DateTime $day;

  private float $turnoverWithoutVat;

  public function __construct(DateTime $day, float $turnoverWithoutVat)
  {
    $this->day = $day;
    $this->turnoverWithoutVat = $turnoverWithoutVat;
  }

  public function getDay(): DateTime
  {
    return $this->day;
  }

  public function getTurnoverWithoutVat(): float
  {
    return $this->turnoverWithoutVat;
  }

  public function __toArray(): array
  {
    return [
      'day' => $this->day->format('Y-m-d'),
      'turnoverWithoutVat' => $this->turnoverWithoutVat
    ];
  }
}