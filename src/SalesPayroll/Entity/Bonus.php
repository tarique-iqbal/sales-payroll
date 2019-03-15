<?php declare(strict_types = 1);

namespace SalesPayroll\Entity;

/**
 * Class Bonus
 * @package SalesPayroll\Entity
 */
class Bonus
{
    /**
     * @var string
     */
    private $paymentMonth;

    /**
     * @var string
     */
    private $bonusPaymentDate;

    /**
     * @return string
     */
    public function getPaymentMonth(): string
    {
        return $this->paymentMonth;
    }

    /**
     * @param string $paymentMonth
     */
    public function setPaymentMonth(string $paymentMonth): void
    {
        $this->paymentMonth = $paymentMonth;
    }

    /**
     * @return string
     */
    public function getBonusPaymentDate(): string
    {
        return $this->bonusPaymentDate;
    }

    /**
     * @param string $bonusPaymentDate
     */
    public function setBonusPaymentDate(string $bonusPaymentDate): void
    {
        $this->bonusPaymentDate = $bonusPaymentDate;
    }
}
