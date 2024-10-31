<?php declare(strict_types=1);

namespace SalesPayroll\Tests\Integration\Container;

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use SalesPayroll\Container\ContainerFactory;
use SalesPayroll\Service\BonusService;
use SalesPayroll\Service\SalaryService;
use SalesPayroll\Service\ConfigService;
use SalesPayroll\Service\CLIArgsService;
use SalesPayroll\Service\CSVFileWriterService;
use SalesPayroll\SalesPayrollApplication;
use SalesPayroll\Handler\ExceptionHandler;

class ContainerFactoryTest extends TestCase
{
    public function testCreate()
    {
        $config = include BASE_DIR . '/config/params_test.php';

        $container = (new ContainerFactory($config))->create();

        $this->assertInstanceOf(Container::class, $container);
        $this->assertInstanceOf(ConfigService::class, $container['ConfigService']);
        $this->assertInstanceOf(CLIArgsService::class, $container['CLIArgsService']);
        $this->assertInstanceOf(SalaryService::class, $container['SalaryService']);
        $this->assertInstanceOf(BonusService::class, $container['BonusService']);
        $this->assertInstanceOf(CSVFileWriterService::class, $container['CSVFileWriterService']);
        $this->assertInstanceOf(SalesPayrollApplication::class, $container['SalesPayrollApplication']);
        $this->assertInstanceOf(ExceptionHandler::class, $container['ExceptionHandler']);
    }
}
