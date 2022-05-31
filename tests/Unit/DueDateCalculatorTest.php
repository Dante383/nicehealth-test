<?php

namespace Tests\Unit;

use App\Component\Billing\DueDateCalculator;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class DueDateCalculatorTest extends TestCase
{
    /**
     * @dataProvider dueDatesProvider
     */
    public function test_calculate_due_date(string $billingStartDate, string $actualTime, string $expected)
    {
        $subject = new DueDateCalculator();
        $this->assertEquals(
            $expected,
            $subject->nextDueDate(new Carbon($billingStartDate), new Carbon($actualTime))->format('Y-m-d')
        );
    }

    public function dueDatesProvider(): iterable
    {
        yield ['2022-01-31', '2022-02-28', '2022-03-31'];
        yield ['2022-01-31', '2022-02-27', '2022-02-28'];
        yield ['2022-01-31', '2022-04-21', '2022-04-30'];
        yield ['2022-01-31', '2022-05-01', '2022-05-31'];
        yield ['2022-02-28', '2022-05-31', '2022-06-28'];
        yield ['2022-02-28', '2022-02-28', '2022-03-28'];
    }

    /**
     * @dataProvider periodsProvider
     */
    public function test_calculate_periods(string $billingStartDate, string $actualTime, int $expected)
    {
        $subject = new DueDateCalculator();
        $this->assertEquals(
            $expected,
            $subject->periods(new Carbon($billingStartDate), new Carbon($actualTime))
        );
    }

    public function periodsProvider(): iterable
    {
        yield ['2022-01-31 14:30:00', '2022-02-28 11:00:00', 1];
        yield ['2022-01-31', '2022-02-28', 1];
        yield ['2022-01-31', '2022-02-27', 0];
        yield ['2022-01-31', '2022-04-21', 2];
        yield ['2022-01-31', '2022-04-30', 3];
        yield ['2022-01-31', '2022-05-30', 3];
        yield ['2022-01-31', '2022-05-31', 4];
        yield ['2022-02-28', '2022-05-31', 3];
        yield ['2022-01-01', '2023-01-01', 12];
        yield ['2021-12-01', '2022-12-01', 12];
    }
}
