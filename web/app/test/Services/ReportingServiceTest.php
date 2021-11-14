<?php

use App\DTOs\TurnoverPerBrand;
use App\DTOs\TurnoverPerDay;
use App\Repositories\GrossMerchandiseValueRepositoryInterface;
use App\Services\TurnoverReportingService;
use AppTest\TestCase;
use Carbon\Carbon;

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

  public function testGenerateTurnoverPerBrandReport()
  {
    $data = [
      new TurnoverPerBrand(
        DateTime::createFromFormat('Y-m-d H:i:s', '2018-05-01 00:00:00'),
        'O-Brand',
        34342.98,
      ),
      new TurnoverPerBrand(
        DateTime::createFromFormat('Y-m-d H:i:s', '2018-05-01 00:00:00'),
        'T-Brand',
        565.89,
      )
    ];
    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();
    $expectedFileName = '7-days-turnover-per-brand-' . $startDate . '.csv';

    $this->gmvRepository
      ->expects($this->once())
      ->method('getTurnoverPerBrand')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn($data);

    $filename = (new TurnoverReportingService($this->gmvRepository, $this->container))
      ->generateTurnoverPerBrandReport($startDate, $duration);

    $this->assertSame($expectedFileName, $filename);
  }

  public function testGenerateTurnoverPerBrandReportWithEmptyData()
  {
    $this->expectException(InvalidArgumentException::class);

    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();

    $this->gmvRepository
      ->expects($this->once())
      ->method('getTurnoverPerBrand')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn([]);

    (new TurnoverReportingService($this->gmvRepository, $this->container))
      ->generateTurnoverPerBrandReport($startDate, $duration);
  }

  public function testGenerateTurnoverPerDayReport()
  {
    $data = [
      new TurnoverPerDay(
        DateTime::createFromFormat('Y-m-d H:i:s', '2018-05-01 00:00:00'),
        34342.98,
      ),
      new TurnoverPerDay(
        DateTime::createFromFormat('Y-m-d H:i:s', '2018-05-01 00:00:00'),
        565.89,
      )
    ];
    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();
    $expectedFileName = '7-days-turnover-per-day-' . $startDate . '.csv';

    $this->gmvRepository
      ->expects($this->once())
      ->method('getTurnoverPerDay')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn($data);

    $filename = (new TurnoverReportingService($this->gmvRepository, $this->container))
      ->generateTurnoverPerDayReport($startDate, $duration);

    $this->assertSame($expectedFileName, $filename);
  }

  public function testGenerateTurnoverPerDayReportWithEmptyData()
  {
    $this->expectException(InvalidArgumentException::class);

    $startDate = '2018-05-01';
    $duration = 6;
    $endDate = Carbon::parse($startDate)->addDays($duration)->toDateString();

    $this->gmvRepository
      ->expects($this->once())
      ->method('getTurnoverPerDay')
      ->with($startDate, $endDate, $this->vat)
      ->willReturn([]);

    (new TurnoverReportingService($this->gmvRepository, $this->container))
      ->generateTurnoverPerDayReport($startDate, $duration);
  }
}