<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Service\SalaryService;

class SalaryServiceTest extends TestCase
{
    protected $salaryService;

    protected function setUp()
    {
        $this->salaryService = new SalaryService();
    }

    public function addSalaryPaymentDatesDataProvider()
    {
        return [
            [
                12,
                '03.05.2018',
                [
                    '06-2018' => '29.06.2018',
                    '07-2018' => '31.07.2018',
                    '08-2018' => '31.08.2018',
                    '09-2018' => '28.09.2018',
                    '10-2018' => '31.10.2018',
                    '11-2018' => '30.11.2018',
                    '12-2018' => '31.12.2018',
                    '01-2019' => '31.01.2019',
                    '02-2019' => '28.02.2019',
                    '03-2019' => '29.03.2019',
                    '04-2019' => '30.04.2019',
                    '05-2019' => '31.05.2019',
                ]
            ],
            [
                2,
                '01.12.2019',
                [
                    '01-2020' => '31.01.2020',
                    '02-2020' => '28.02.2020',
                ]
            ],
        ];
    }

    /**
     * @dataProvider addSalaryPaymentDatesDataProvider
     */
    public function testGetSalaryPaymentDates(int $numberOfMonths, string $date, array $expectedPaymentDates)
    {
        $salaryPaymentDates = $this->salaryService->getSalaryPaymentDates($numberOfMonths, $date);

        foreach ($expectedPaymentDates as $month => $salaryPaymentDate) {
            $salary = $salaryPaymentDates[$month];

            $this->assertSame($salaryPaymentDate, $salary->getSalaryPaymentDate());
        }
    }

    public function addSalaryPaymentDatesUnusualCaseDataProvider()
    {
        return [
            [
                0,
                '03.05.2018',
            ],
            [
                -1,
                '01.12.2019',
            ],
        ];
    }

    /**
     * @dataProvider addSalaryPaymentDatesUnusualCaseDataProvider
     */
    public function testGetSalaryPaymentDatesUnusualCase(int $numberOfMonths, string $date)
    {
        $salaryPaymentDates = $this->salaryService->getSalaryPaymentDates($numberOfMonths, $date);

        $this->assertEquals(0, count($salaryPaymentDates));
    }
}
