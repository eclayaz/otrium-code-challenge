<?php

namespace App\DTOs;

use Cassandra\Type\Collection;

/**
 * @ORM\Entity()
 */
class GMV
{
  /**
   * @var Collection
   * @ORM\OneToMany(targetEntity="GMV", mappedBy="brands")
   */
  private Collection $incomes;
}