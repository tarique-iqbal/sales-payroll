<?php declare(strict_types = 1);

namespace SalesPayroll;

use SalesPayroll\Service\FileWriterServiceInterface;
use SalesPayroll\Service\ConfigServiceInterface;
use SalesPayroll\Service\CLIArgsServiceInterface;
use SalesPayroll\Validator\FileNameValidator;
use SalesPayroll\Exception\FileOpenException;
use SalesPayroll\Exception\UnknownFileNameException;

/**
 * Class SalesPayrollApplication
 * @package SalesPayroll\Application
 */
class SalesPayrollApplication
{
    const NUMBER_OF_MONTHS = 12;

    private $configService;
    private $cliArgsService;
    private $csvFileWriterService;
    private $fileNameValidator;

    /**
     * SalesPayrollApplication constructor.
     * @param ConfigServiceInterface $configService
     * @param CLIArgsServiceInterface $cliArgsService
     * @param FileWriterServiceInterface $csvFileWriterService
     * @param FileNameValidator $fileNameValidator
     */
    public function __construct(
        ConfigServiceInterface $configService,
        CLIArgsServiceInterface $cliArgsService,
        FileWriterServiceInterface $csvFileWriterService,
        FileNameValidator $fileNameValidator
    ) {
        $this->configService = $configService;
        $this->cliArgsService = $cliArgsService;
        $this->csvFileWriterService = $csvFileWriterService;
        $this->fileNameValidator = $fileNameValidator;
    }

    /**
     * @throws UnknownFileNameException
     * @throws FileOpenException
     */
    public function writeSalaryBonusPaymentDates(): void
    {
        $args = $this->cliArgsService->getArgs();
        $fileName = $this->getFileName($args);

        if ($this->fileNameValidator->isValid($fileName) === true) {
            if ($this->isFileExists($fileName) === true) {
                if ($this->isOverwriteFile($fileName) === true) {
                    $this->writeCSVFile($fileName);
                }
            } else {
                $this->writeCSVFile($fileName);
            }
        } else {
            echo $this->fileNameValidator->getErrorMessage();
        }
    }

    /**
     * @param array $args
     * @return string
     * @throws UnknownFileNameException
     */
    private function getFileName(array $args): string
    {
        if (isset($args['file'])) {
            return $args['file'];
        } elseif (isset($args['f'])) {
            return $args['f'];
        } elseif (isset($args[0])) {
            return $args[0];
        }

        echo 'Unknown file name. Please provide a valid file name.' . PHP_EOL;

        throw new UnknownFileNameException('No file name provided via CLI.');
    }

    /**
     * @param string $fileName
     * @throws FileOpenException
     */
    private function writeCSVFile(string $fileName): void
    {
        $today = date('d.m.Y');
        $csvFileLocation = $this->configService
                                ->getDataPath(). '/' . $fileName;

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
        $csvFileLocation = $this->configService->getDataPath() . '/' . $fileName;

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
