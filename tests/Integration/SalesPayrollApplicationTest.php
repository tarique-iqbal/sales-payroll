<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration;

use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use SalesPayroll\Container\ContainerFactory;
use SalesPayroll\Exception\FileOpenException;
use SalesPayroll\Service\ConfigServiceInterface;
use SalesPayroll\Service\CLIArgsServiceInterface;

class SalesPayrollApplicationTest extends TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/params_test.php';
        $this->container = (new ContainerFactory($config))->create();

        $this->container['CLIArgsService'] = $this->getMockBuilder(CLIArgsServiceInterface::class)->getMock();
    }

    protected function tearDown(): void
    {
        $configService = $this->container['ConfigService'];
        $csvFileLocation = $configService->getDataPath() . '/test-case.csv';

        if (file_exists($csvFileLocation)) {
            unlink($csvFileLocation);
        }
    }

    public function testWriteSalaryBonusPaymentDates()
    {
        $this->expectOutputString('The CSV file has been created successfully.' . PHP_EOL);

        $this->container['CLIArgsService']->method('getArgs')->willReturn(['test-case.csv']);
        $this->container['SalesPayrollApplication']->writeSalaryBonusPaymentDates();

        $csvFileLocation = $this->container['ConfigService']->getDataPath() . '/test-case.csv';

        $this->assertTrue(file_exists($csvFileLocation));
    }

    public function testWriteSalaryBonusPaymentDatesInvalidInput()
    {
        $this->expectException(LazyAssertionException::class);

        $this->container['CLIArgsService']->method('getArgs')->willReturn([]);
        $this->container['SalesPayrollApplication']->writeSalaryBonusPaymentDates();
    }

    public function testWriteSalaryBonusPaymentDatesInvalidDirectory()
    {
        $this->expectException(FileOpenException::class);

        $this->container['ConfigService'] = $this->getMockBuilder(ConfigServiceInterface::class)->getMock();

        $this->container['ConfigService']->method('getDataPath')->willReturn('invalid/path');
        $this->container['CLIArgsService']->method('getArgs')->willReturn(['test-case.csv']);

        ini_set('error_reporting', 'E_ALL');
        ini_set('display_errors', 'Off');

        $this->container['SalesPayrollApplication']->writeSalaryBonusPaymentDates();
    }
}
