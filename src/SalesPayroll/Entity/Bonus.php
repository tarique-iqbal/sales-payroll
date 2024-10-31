<?php declare(strict_types=1);

namespace SalesPayroll\Entity;

class Bonus
{
    private string $paymentMonth;

    private string $bonusPaymentDate;

    public function getPaymentMonth(): string
    {
        return $this->paymentMonth;
    }

    public function setPaymentMonth(string $paymentMonth): void
    {
        $this->paymentMonth = $paymentMonth;
    }

    public function getBonusPaymentDate(): string
    {
        return $this->bonusPaymentDate;
    }

    public function setBonusPaymentDate(string $bonusPaymentDate): void
    {
        $this->bonusPaymentDate = $bonusPaymentDate;
    }
}
