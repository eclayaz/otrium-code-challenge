<?php

use App\Repositories\GrossMerchandiseValueRepository;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Services\TurnoverReportingService;
use AppTest\TestCase;
use Carbon\Carbon;
use PHPUnit\Framework\MockObject\MockObject;

class ReportingServiceTest extends TestCase
{
  private $gmvRepository;
  private $vat;

  protected function setUp(): void
  {
    parent::setUp();
    $this->gmvRepository = $this->createMock(GrossMerchandiseValueRepositoryInterface::class);
    $this->vat = $this->container->get('vat_percentage');
  }

  /**
   * @test
   */
  public function createTurnoverPerBrandReport_withCorrectStartDateAndDuration_createCSVAndReturnFileName()
  {
    $data = [
      [
        'day' => '2018-05-01 00:00:00',
        'brand_name' => 'O-Brand',
        'turnover_excluding_vat' => 8400.2754
      ]
    ];
    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();
    $expectedFileName = '7-days-turnover-per-brand-' . $startDate . '.csv';

    $this->gmvRepository
      ->expects($this->once())
      ->method('getSevenDayTurnoverPerBrand')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn($data);

    $filename = (new TurnoverReportingService($this->gmvRepository, $this->container))->generateTurnoverPerBrandReport($startDate, $duration);

    $this->assertSame($expectedFileName, $filename);
  }

  /**
   * @test
   */
  public function createTurnoverPerDayReport_withCorrectStartDateAndDuration_createCSVAndReturnFileName()
  {
    $data = [
      [
        'day' => '2018-05-01 00:00:00',
        'turnover_excluding_vat' => 8400.2754
      ]
    ];
    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();
    $expectedFileName = '7-days-turnover-per-day-' . $startDate . '.csv';

    $this->gmvRepository
      ->expects($this->once())
      ->method('getSevenDayTurnoverPerDay')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn($data);

    $filename = (new TurnoverReportingService($this->gmvRepository, $this->container))->generateTurnoverPerDayReport($startDate, $duration);

    $this->assertSame($expectedFileName, $filename);
  }
}