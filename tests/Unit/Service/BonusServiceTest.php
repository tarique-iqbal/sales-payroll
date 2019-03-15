<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Service\BonusService;

class BonusServiceTest extends TestCase
{
    protected $bonusService;

    protected function setUp()
    {
        $this->bonusService = new BonusService();
    }

    public function addBonusPaymentDatesDataProvider()
    {
        return [
            [
                12,
                '03.05.2018',
                [
                    '06-2018' => '18.07.2018',
                    '07-2018' => '15.08.2018',
                    '08-2018' => '19.09.2018',
                    '09-2018' => '15.10.2018',
                    '10-2018' => '15.11.2018',
                    '11-2018' => '19.12.2018',
                    '12-2018' => '15.01.2019',
                    '01-2019' => '15.02.2019',
                    '02-2019' => '15.03.2019',
                    '03-2019' => '15.04.2019',
                    '04-2019' => '15.05.2019',
                    '05-2019' => '19.06.2019',
                ]
            ],
            [
                2,
                '01.12.2019',
                [
                    '01-2020' => '19.02.2020',
                    '02-2020' => '18.03.2020',
                ]
            ],
        ];
    }

    /**
     * @dataProvider addBonusPaymentDatesDataProvider
     */
    public function testGetBonusPaymentDates(int $numberOfMonths, string $date, array $expectedPaymentDates)
    {
        $bonusPaymentDates = $this->bonusService->getBonusPaymentDates($numberOfMonths, $date);

        foreach ($expectedPaymentDates as $month => $bonusPaymentDate) {
            $bonus = $bonusPaymentDates[$month];

            $this->assertSame($bonusPaymentDate, $bonus->getBonusPaymentDate());
        }
    }

    public function addBonusPaymentDatesUnusualCaseDataProvider()
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
     * @dataProvider addBonusPaymentDatesUnusualCaseDataProvider
     */
    public function testGetBonusPaymentDatesUnusualCase(int $numberOfMonths, string $date)
    {
        $bonusPaymentDates = $this->bonusService->getBonusPaymentDates($numberOfMonths, $date);

        $this->assertEquals(0, count($bonusPaymentDates));
    }
}
