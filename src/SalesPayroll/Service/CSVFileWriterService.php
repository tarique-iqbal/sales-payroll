<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

use SalesPayroll\Exception\FileOpenException;

/**
 * Class BonusService
 * @package SalesPayroll\Service
 */
class CSVFileWriterService implements FileWriterServiceInterface
{
    const CSV_HEADER = ['Month Name', 'Salary Payment Date', 'Bonus Payment Date'];

    private SalaryServiceInterface $salaryService;
    private BonusServiceInterface $bonusService;

    /**
     * CSVFileWriterService constructor.
     * @param SalaryServiceInterface $salaryService
     * @param BonusServiceInterface $bonusService
     */
    public function __construct(
        SalaryServiceInterface $salaryService,
        BonusServiceInterface $bonusService
    ) {
        $this->salaryService = $salaryService;
        $this->bonusService = $bonusService;
    }

    /**
     * @param string $csvFileLocation
     * @param int $numberOfMonths
     * @param string $today
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
