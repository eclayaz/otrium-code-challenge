<?php

use App\Exceptions\NotFoundHttpException;
use App\Repositories\GrossMerchandiseValueRepository;
use AppTest\TestCase;
use Doctrine\DBAL\Connection;

class GrossMerchandiseValueRepositoryTest extends TestCase
{
  private $gmvRepository;

  protected function setUp(): void
  {
    parent::setUp();
    $this->gmvRepository = new GrossMerchandiseValueRepository($this->container->get(Connection::class));
  }

  /**
   * @test
   */
  public function getSevenDayTurnoverPerDay_withCorrectParam_willReturnExpectedDate()
  {
    $data = $this->gmvRepository->getSevenDayTurnoverPerDay('2018-05-01', '2018-05-07', .21);

    $this->assertIsArray($data);
    $this->assertArrayHasKey('day', $data[0]);
    $this->assertArrayHasKey('turnover_excluding_vat', $data[0]);
  }

  /**
   * @test
   */
  public function getSevenDayTurnoverPerDay_withIncorrectDateRange_willReturnNotFoundException()
  {
    $this->expectException(NotFoundHttpException::class);

    $this->gmvRepository->getSevenDayTurnoverPerDay('2021-05-01', '2021-05-07', .21);
  }

  /**
   * @test
   */
  public function getSevenDayTurnoverPerBrand_withCorrectParam_willReturnExpectedDate()
  {
    $data = $this->gmvRepository->getSevenDayTurnoverPerBrand('2018-05-01', '2018-05-07', .21);

    $this->assertIsArray($data);
    $this->assertArrayHasKey('day', $data[0]);
    $this->assertArrayHasKey('brand_name', $data[0]);
    $this->assertArrayHasKey('turnover_excluding_vat', $data[0]);
  }


  /**
   * @test
   */
  public function getSevenDayTurnoverPerBrand_withIncorrectDateRange_willReturnNotFoundException()
  {
    $this->expectException(NotFoundHttpException::class);

    $this->gmvRepository->getSevenDayTurnoverPerBrand('2021-05-01', '2021-05-07', .21);
  }
}