<?php declare(strict_types = 1);

namespace SalesPayroll\Entity;

/**
 * Class Salary
 * @package SalesPayroll\Entity
 */
class Salary
{
    /**
     * @var string
     */
    private string $paymentMonth;

    /**
     * @var string
     */
    private string $salaryPaymentDate;

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
    public function getSalaryPaymentDate(): string
    {
        return $this->salaryPaymentDate;
    }

    /**
     * @param string $salaryPaymentDate
     */
    public function setSalaryPaymentDate(string $salaryPaymentDate): void
    {
        $this->salaryPaymentDate = $salaryPaymentDate;
    }
}
