<?php declare(strict_types=1);

namespace SalesPayroll;

use Assert\Assert;
use SalesPayroll\Service\FileWriterServiceInterface;
use SalesPayroll\Service\ConfigServiceInterface;
use SalesPayroll\Service\CLIArgsServiceInterface;
use SalesPayroll\Utility\Utility;

final class SalesPayrollApplication
{
    private const INPUT_SIZE = 1;

    private const NUMBER_OF_MONTHS = 12;

    public function __construct(
        private readonly ConfigServiceInterface $configService,
        private readonly CLIArgsServiceInterface $cliArgsService,
        private readonly FileWriterServiceInterface $csvFileWriterService
    ) {
    }

    public function writeSalaryBonusPaymentDates(): void
    {
        $inputArgs = $this->cliArgsService->getArgs();
        $fileName = current($inputArgs);

        Assert::lazy()
            ->that($inputArgs, 'inputArgs')->isArray()->count(self::INPUT_SIZE)
            ->that($fileName, 'fileName')->regex('/^[a-z]{1}[a-z0-9.\-]+\.csv$/i')
            ->verifyNow();

        $csvFileLocation = $this->configService->getDataPath() . '/' . $fileName;

        if (Utility::isFileExists($csvFileLocation) === true) {
            if (Utility::isOverwriteFile($fileName) === true) {
                $this->writeCSVFile($fileName);
            }
        } else {
            $this->writeCSVFile($fileName);
        }
    }

    private function writeCSVFile(string $fileName): void
    {
        $today = date('d.m.Y');
        $csvFileLocation = $this->configService->getDataPath() . '/' . $fileName;

        $this->csvFileWriterService
             ->writeFile($csvFileLocation, self::NUMBER_OF_MONTHS, $today);

        echo sprintf('The CSV file has been created successfully.%s', PHP_EOL);
    }
}
