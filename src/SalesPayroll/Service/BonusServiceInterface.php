<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

interface BonusServiceInterface
{
    public function getBonusPaymentDates(int $numberOfMonths, string $today): array;
}
