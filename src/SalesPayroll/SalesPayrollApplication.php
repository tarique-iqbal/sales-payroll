<?php declare(strict_types = 1);

namespace SalesPayroll;

use SalesPayroll\Service\FileWriterServiceInterface;
use SalesPayroll\Service\ConfigServiceInterface;
use SalesPayroll\Service\CLIArgsServiceInterface;
use SalesPayroll\Exception\FileOpenException;
use SalesPayroll\Validator\ArrayHasKeyValidator;
use SalesPayroll\Validator\ArraySizeValidator;
use SalesPayroll\Validator\FileNameValidator;

/**
 * Class SalesPayrollApplication
 * @package SalesPayroll\Application
 */
class SalesPayrollApplication
{
    const INPUT_SIZE = 1;

    const NUMBER_OF_MONTHS = 12;

    /**
     * @var ConfigServiceInterface
     */
    private $configService;

    /**
     * @var CLIArgsServiceInterface
     */
    private $cliArgsService;

    /**
     * @var FileWriterServiceInterface
     */
    private $csvFileWriterService;

    /**
     * SalesPayrollApplication constructor.
     * @param ConfigServiceInterface $configService
     * @param CLIArgsServiceInterface $cliArgsService
     * @param FileWriterServiceInterface $csvFileWriterService
     */
    public function __construct(
        ConfigServiceInterface $configService,
        CLIArgsServiceInterface $cliArgsService,
        FileWriterServiceInterface $csvFileWriterService
    ) {
        $this->configService = $configService;
        $this->cliArgsService = $cliArgsService;
        $this->csvFileWriterService = $csvFileWriterService;
    }

    /**
     * @throws FileOpenException
     */
    public function writeSalaryBonusPaymentDates(): void
    {
        $fileNameArgs = $this->cliArgsService->getArgs();

        if ($this->validateInput($fileNameArgs) === true) {
            $fileName = current($fileNameArgs);

            if ($this->isFileExists($fileName) === true) {
                if ($this->isOverwriteFile($fileName) === true) {
                    $this->writeCSVFile($fileName);
                }
            } else {
                $this->writeCSVFile($fileName);
            }
        }
    }

    /**
     * @param array $fileName
     * @return bool
     */
    private function validateInput(array $fileName): bool
    {
        $arraySizeValidator = new ArraySizeValidator();

        if ($arraySizeValidator->isValid($fileName, self::INPUT_SIZE) === false) {
            echo $arraySizeValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        $arrayHasKeyValidator = new ArrayHasKeyValidator();

        if ($arrayHasKeyValidator->isValid($fileName) === false) {
            echo $arrayHasKeyValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        $fileNameValidator = new FileNameValidator();

        if ($fileNameValidator->isValid(current($fileName)) === false) {
            echo $fileNameValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        return true;
    }

    /**
     * @param string $fileName
     * @throws FileOpenException
     */
    private function writeCSVFile(string $fileName): void
    {
        $today = date('d.m.Y');
        $csvFileLocation = $this->configService
                                ->getDataPath() . '/' . $fileName;

        $this->csvFileWriterService
             ->writeFile($csvFileLocation, self::NUMBER_OF_MONTHS, $today);

        echo 'The CSV file has been created successfully.' . PHP_EOL;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    private function isFileExists(string $fileName): bool
    {
        $csvFileLocation = $this->configService
                                ->getDataPath() . '/' . $fileName;

        if (file_exists($csvFileLocation)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    private function isOverwriteFile(string $fileName): bool
    {
        echo $fileName . ' file already exists! Are you sure you want to overwrite it (y/n)? :';
        $handle = fopen('php://stdin', 'r');
        $line = fgets($handle);

        if (strtolower(trim($line)) === 'y') {
            return true;
        }

        echo 'Action aborted.' . PHP_EOL;

        return false;
    }
}
