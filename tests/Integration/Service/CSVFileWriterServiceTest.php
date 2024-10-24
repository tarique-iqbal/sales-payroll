<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration\Service;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use SalesPayroll\Exception\FileOpenException;
use SalesPayroll\Service\BonusService;
use SalesPayroll\Service\ConfigService;
use SalesPayroll\Service\FileWriterServiceInterface;
use SalesPayroll\Service\SalaryService;
use SalesPayroll\Service\CSVFileWriterService;

class CSVFileWriterServiceTest extends TestCase
{
    protected string $csvFileLocation;

    protected FileWriterServiceInterface $csvFileWriterService;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/params_test.php';
        $configService = new ConfigService($config);
        $this->csvFileLocation = $configService->getDataPath() . '/test-case.csv';
        $this->csvFileWriterService = new CSVFileWriterService(new SalaryService(), new BonusService());
    }

    protected function tearDown(): void
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

    public function testWriteFileWithInvalidDirectory()
    {
        $this->expectException(FileOpenException::class);

        $numberOfMonths = 12;
        $today = date('d.m.Y');
        $csvFile = '/path/to/invalid/test-case.csv';

        ini_set('error_reporting', 'E_ALL');
        ini_set('display_errors', 'Off');

        $this->csvFileWriterService->writeFile($csvFile, $numberOfMonths, $today);
    }

    public function testWriteFileUsingVfsStream()
    {
        $numberOfMonths = 1;
        $today = '01.12.2019';
        $structure = [
            'csv' => [

            ]
        ];

        $root = vfsStream::setup(sys_get_temp_dir(), null, $structure);
        $this->csvFileWriterService->writeFile($root->url() . '/csv/test-case.csv', $numberOfMonths, $today);

        $this->assertTrue($root->hasChild('csv/test-case.csv'));
        $this->assertSame(
            "\"Month Name\",\"Salary Payment Date\",\"Bonus Payment Date\"\nJanuary,31.01.2020,19.02.2020\n",
            $root->getChild('csv/test-case.csv')->getContent()
        );
    }
}
