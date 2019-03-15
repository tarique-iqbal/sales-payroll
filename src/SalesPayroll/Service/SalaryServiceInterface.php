<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

/**
 * Interface SalaryServiceInterface
 * @package SalesPayroll\Service
 */
interface SalaryServiceInterface
{
    /**
     * @param int $numberOfMonths
     * @param string $today
     * @return array
     */
    public function getSalaryPaymentDates(int $numberOfMonths, string $today): array;
}
