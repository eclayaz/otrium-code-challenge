<?php

namespace App\Repositories\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="gmv")
 */
class GMV
{
  /**
   * @Id()
   * @GeneratedValue()
   * @Column(type="integer")
   */
  private int $id;

  /**
   * @ManyToOne(targetEntity="Brand", inversedBy="gmv")
   * @JoinColumn(name="brand_id", referencedColumnName="id")
   */
  private Brand $brand;

  /**
   * @Column(type="datetime", nullable=false)
   */
  private \DateTime $date;

  /**
   * @Column(type="float", nullable=false)
   */
  private \DateTime $turnover;
}