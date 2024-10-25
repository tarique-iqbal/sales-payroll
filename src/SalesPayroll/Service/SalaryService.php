<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

use SalesPayroll\Entity\Salary;

final class SalaryService implements SalaryServiceInterface
{
    private const SECONDS_IN_A_DAY = 86400;

    private const MONTHS_IN_A_YEAR = 12;

    public function getSalaryPaymentDates(int $numberOfMonths, string $today): array
    {
        $date = \DateTime::createFromFormat('d.m.Y', $today);
        $nextMonth = intval($date->format('n')) + 1;
        $year = intval($date->format('Y'));
        $salaryPaymentDates = [];
        $i = 1;

        while ($i <= $numberOfMonths) {
            if ($nextMonth >= (self::MONTHS_IN_A_YEAR + 1)) {
                $nextMonth = 1;
                $year = $year + 1;
            }

            $monthYear = $this->getPaymentMonth($nextMonth, $year);
            $salaryPaymentDate = $this->getSalaryPaymentDate($nextMonth, $year);

            $salary = new Salary();
            $salary->setPaymentMonth($monthYear);
            $salary->setSalaryPaymentDate($salaryPaymentDate);

            $salaryPaymentDates[$monthYear] = $salary;

            $nextMonth++;
            $i++;
        }

        return $salaryPaymentDates;
    }

    private function getPaymentMonth(int $month, int $year): string
    {
        $monthStart = mktime(0, 0, 0, $month, 1, $year);
        return date('m-Y', $monthStart);
    }

    private function getSalaryPaymentDate(int $month, int $year): string
    {
        $salaryPaymentDate = mktime(0, 0, 0, $month + 1, 1, $year) - self::SECONDS_IN_A_DAY;
        $dayName = date('l', $salaryPaymentDate);

        if ($dayName === 'Saturday') {
            $salaryPaymentDate = $salaryPaymentDate - self::SECONDS_IN_A_DAY;
        } elseif ($dayName === 'Sunday') {
            $salaryPaymentDate = $salaryPaymentDate - (2 * self::SECONDS_IN_A_DAY);
        }

        return date('d.m.Y', $salaryPaymentDate);
    }
}
