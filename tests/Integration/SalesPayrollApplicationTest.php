<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Container\ContainerFactory;
use SalesPayroll\Service\ConfigServiceInterface;
use SalesPayroll\Service\CLIArgsServiceInterface;

class SalesPayrollApplicationTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $config = include BASE_DIR . '/config/params_test.php';
        $this->container = (new ContainerFactory($config))->create();

        $this->container['CLIArgsService'] = $this->getMockBuilder(CLIArgsServiceInterface::class)->getMock();
    }

    protected function tearDown()
    {
        $configService = $this->container['ConfigService'];
        $csvFileLocation = $configService->getDataPath() . '/test-case.csv';

        if (file_exists($csvFileLocation)) {
            unlink($csvFileLocation);
        }
    }

    public function testWriteSalaryBonusPaymentDates()
    {
        $configService = $this->container['ConfigService'];
        $cliArgsService = $this->container['CLIArgsService'];
        $salesPayrollApplication = $this->container['SalesPayrollApplication'];

        $cliArgsService->method('getArgs')->willReturn(['test-case.csv']);

        $this->setOutputCallback(function() {});

        $salesPayrollApplication->writeSalaryBonusPaymentDates();

        $csvFileLocation = $configService->getDataPath() . '/test-case.csv';

        $this->assertTrue(file_exists($csvFileLocation));
    }

    /**
     * @expectedException \SalesPayroll\Exception\FileOpenException
     */
    public function testWriteSalaryBonusPaymentDatesWithInvalidDirectory()
    {
        $this->container['ConfigService'] = $this->getMockBuilder(ConfigServiceInterface::class)->getMock();

        $configService = $this->container['ConfigService'];
        $cliArgsService = $this->container['CLIArgsService'];
        $salesPayrollApplication = $this->container['SalesPayrollApplication'];

        $configService->method('getDataPath')->willReturn('invalid/path');
        $cliArgsService->method('getArgs')->willReturn(['test-case.csv']);

        ini_set('error_reporting', 'E_ALL');
        ini_set('display_errors', 'Off');

        $salesPayrollApplication->writeSalaryBonusPaymentDates();
    }

    public function addInvalidArgumentDataProvider()
    {
        return [
            [
                [null]
            ],
            [
                [null, 'data.csv']
            ],
        ];
    }

    /**
     * @dataProvider addInvalidArgumentDataProvider
     * @expectedException \SalesPayroll\Exception\UnknownFileNameException
     */
    public function testWriteSalaryBonusPaymentDatesWithInvalidArgument(array $args)
    {
        $cliArgsService = $this->container['CLIArgsService'];
        $salesPayrollApplication = $this->container['SalesPayrollApplication'];

        $cliArgsService->method('getArgs')->willReturn($args);

        $this->setOutputCallback(function() {});

        $salesPayrollApplication->writeSalaryBonusPaymentDates();
    }
}
