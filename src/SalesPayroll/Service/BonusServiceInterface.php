<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

/**
 * Interface BonusServiceInterface
 * @package SalesPayroll\Service
 */
interface BonusServiceInterface
{
    /**
     * @param int $numberOfMonths
     * @param string $today
     * @return array
     */
    public function getBonusPaymentDates(int $numberOfMonths, string $today): array;
}
