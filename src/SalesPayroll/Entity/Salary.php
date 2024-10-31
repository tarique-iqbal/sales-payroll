<?php declare(strict_types=1);

namespace SalesPayroll\Entity;

class Salary
{
    private string $paymentMonth;

    private string $salaryPaymentDate;

    public function getPaymentMonth(): string
    {
        return $this->paymentMonth;
    }

    public function setPaymentMonth(string $paymentMonth): void
    {
        $this->paymentMonth = $paymentMonth;
    }

    public function getSalaryPaymentDate(): string
    {
        return $this->salaryPaymentDate;
    }

    public function setSalaryPaymentDate(string $salaryPaymentDate): void
    {
        $this->salaryPaymentDate = $salaryPaymentDate;
    }
}
