<?php

namespace App\Repositories\Entities;

use Cassandra\Type\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="brands")
 */
final class Brand
{
  /**
   * @Id @Column(type="integer")
   * @GeneratedValue
   */
  public int $id;

  /**
   * @Column(type="string", length=255, nullable=false)
   */
  private string $name;

  /**
   * @Column(type="string", length=255, nullable=true)
   */
  public string $description;

  /**
   * @Column(type="integer", length=255, nullable=false)
   */
  public string $products;

  /**
   * @Column(type="datetime", nullable=false)
   */
  public string $created;

  /**
   * @var Collection
   * @OneToMany(targetEntity="GMV", mappedBy="brands")
   */
  private Collection $gmv;
}