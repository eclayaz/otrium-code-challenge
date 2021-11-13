<?php

namespace App\DTOs;

use Cassandra\Type\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="brands")
 */
final class Brand
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private ?int $id;

  /**
   * @ORM\Column(type="string", length=255, nullable=false)
   */
  private string $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private string $description;

  /**
   * @ORM\Column(type="integer", length=255, nullable=false)
   */
  private string $products;

  /**
   * @ORM\Column(type="datetime", nullable=false)
   */
  private string $created;
}