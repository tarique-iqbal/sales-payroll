<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

interface SalaryServiceInterface
{
    public function getSalaryPaymentDates(int $numberOfMonths, string $today): array;
}
