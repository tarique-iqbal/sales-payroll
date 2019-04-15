<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Service\BonusService;
use SalesPayroll\Service\ConfigService;
use SalesPayroll\Service\SalaryService;
use SalesPayroll\Service\CSVFileWriterService;

class CSVFileWriterServiceTest extends TestCase
{
    protected $csvFileLocation;

    protected $csvFileWriterService;

    protected function setUp()
    {
        $config = include BASE_DIR . '/tests/Fixture/config/params.php';
        $configService = new ConfigService($config);
        $this->csvFileLocation = $configService->getDataPath() . '/test-case.csv';
        $this->csvFileWriterService = new CSVFileWriterService(new SalaryService(), new BonusService());
    }

    protected function tearDown()
    {
        if (file_exists($this->csvFileLocation)) {
            unlink($this->csvFileLocation);
        }
    }

    public function testWriteFile()
    {
        $numberOfMonths = 12;
        $today = date('d.m.Y');

        $this->csvFileWriterService->writeFile($this->csvFileLocation, $numberOfMonths, $today);

        $this->assertTrue(file_exists($this->csvFileLocation));
    }

    /**
     * @expectedException \SalesPayroll\Exception\FileOpenException
     */
    public function testWriteFileWithInvalidDirectory()
    {
        $numberOfMonths = 12;
        $today = date('d.m.Y');
        $csvFile = '/path/to/invalid/test-case.csv';

        ini_set('error_reporting', 'E_ALL');
        ini_set('display_errors', 'Off');

        $this->csvFileWriterService->writeFile($csvFile, $numberOfMonths, $today);
    }
}
