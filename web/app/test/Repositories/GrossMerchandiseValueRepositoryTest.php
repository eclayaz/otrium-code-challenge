<?php

use App\DTOs\TurnoverPerBrand;
use App\DTOs\TurnoverPerDay;
use App\Exceptions\NotFoundHttpException;
use App\Repositories\GrossMerchandiseValueRepository;
use AppTest\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class GrossMerchandiseValueRepositoryTest extends TestCase
{
  private GrossMerchandiseValueRepository $gmvRepository;

  protected function setUp(): void
  {
    parent::setUp();
    $this->gmvRepository = new GrossMerchandiseValueRepository(
      $this->container->get(EntityManagerInterface::class)
    );
  }

  public function testGetTurnoverPerDayWithInvalidDatePeriod()
  {
    $this->expectException(NotFoundHttpException::class);
    $data = $this->gmvRepository->getTurnoverPerDay('2021-01-01', '2018-01-07', 0.21);
  }

  public function testGetTurnoverPerDayWithValidDatePeriod()
  {
    $data = $this->gmvRepository->getTurnoverPerDay('2018-05-01', '2018-05-07', 0.21);
    $this->assertIsArray($data);
    $this->assertInstanceOf(TurnoverPerDay::class, $data[0]);
  }

  public function testGetTurnoverPerBrandWithInvalidDatePeriod()
  {
    $this->expectException(NotFoundHttpException::class);
    $data = $this->gmvRepository->getTurnoverPerBrand('2021-01-01', '2018-01-07', 0.21);
  }

  public function testGetTurnoverPerBrandWithValidDatePeriod()
  {
    $data = $this->gmvRepository->getTurnoverPerBrand('2018-05-01', '2018-05-07', 0.21);
    $this->assertIsArray($data);
    $this->assertInstanceOf(TurnoverPerBrand::class, $data[0]);
  }
}