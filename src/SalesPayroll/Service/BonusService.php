<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

use SalesPayroll\Entity\Bonus;

/**
 * Class BonusService
 * @package SalesPayroll\Service
 */
class BonusService implements BonusServiceInterface
{
    const SECONDS_IN_A_DAY = 86400;
    const MONTHS_IN_A_YEAR = 12;

    /**
     * @param int $numberOfMonths
     * @param string $today
     * @return array
     */
    public function getBonusPaymentDates(int $numberOfMonths, string $today): array
    {
        $date = \DateTime::createFromFormat('d.m.Y', $today);
        $nextMonth = intval($date->format('n')) + 1;
        $year = intval($date->format('Y'));
        $bonusPaymentDates = [];
        $i = 1;

        while ($i <= $numberOfMonths) {
            if ($nextMonth >= (self::MONTHS_IN_A_YEAR + 1)) {
                $nextMonth = 1;
                $year = $year + 1;
            }

            $monthYear = $this->getPaymentMonth($nextMonth, $year);
            $bonusPaymentDate = $this->getBonusPaymentDate($nextMonth, $year);

            $bonus = new Bonus();
            $bonus->setPaymentMonth($monthYear);
            $bonus->setBonusPaymentDate($bonusPaymentDate);

            $bonusPaymentDates[$monthYear] = $bonus;

            $nextMonth++;
            $i++;
        }

        return $bonusPaymentDates;
    }

    /**
     * @param int $month
     * @param int $year
     * @return string
     */
    private function getPaymentMonth(int $month, int $year): string
    {
        $monthStart = mktime(0, 0, 0, $month, 1, $year);
        return date('m-Y', $monthStart);
    }

    /**
     * @param int $month
     * @param int $year
     * @return string
     */
    private function getBonusPaymentDate(int $month, int $year): string
    {
        $bonusPaymentDate = mktime(0, 0, 0, $month + 1, 15, $year);
        $dayName = date('l', $bonusPaymentDate);

        if ($dayName === 'Saturday') {
            $bonusPaymentDate = $bonusPaymentDate + (4 * self::SECONDS_IN_A_DAY);
        } elseif ($dayName === 'Sunday') {
            $bonusPaymentDate = $bonusPaymentDate + (3 * self::SECONDS_IN_A_DAY);
        }

        return date('d.m.Y', $bonusPaymentDate);
    }
}
