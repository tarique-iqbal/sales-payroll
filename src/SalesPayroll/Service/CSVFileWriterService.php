<?php declare(strict_types=1);

namespace SalesPayroll\Service;

use SalesPayroll\Exception\FileOpenException;

final class CSVFileWriterService implements FileWriterServiceInterface
{
    const CSV_HEADER = ['Month Name', 'Salary Payment Date', 'Bonus Payment Date'];

    public function __construct(
        private readonly SalaryServiceInterface $salaryService,
        private readonly BonusServiceInterface $bonusService
    ) {
    }

    /**
     * @throws FileOpenException
     */
    public function writeFile(string $csvFileLocation, int $numberOfMonths, string $today): void
    {
        $salaryPaymentDates = $this->salaryService
                                   ->getSalaryPaymentDates($numberOfMonths, $today);
        $bonusPaymentDates = $this->bonusService
                                  ->getBonusPaymentDates($numberOfMonths, $today);

        $fp = fopen($csvFileLocation, 'w');

        if ($fp === false) {
            throw new FileOpenException('File open failed: ' . $csvFileLocation);
        }

        fputcsv($fp, self::CSV_HEADER);
        foreach ($salaryPaymentDates as $salary) {
            $paymentMonth = $salary->getPaymentMonth();
            $salaryPaymentDate = $salary->getSalaryPaymentDate();

            $bonus = $bonusPaymentDates[$paymentMonth];
            $bonusPaymentDate = $bonus->getBonusPaymentDate();

            $date = \DateTime::createFromFormat('m-Y', $paymentMonth);
            $monthName = $date->format('F');

            fputcsv($fp, [$monthName, $salaryPaymentDate, $bonusPaymentDate]);
        }

        fclose($fp);
    }
}
