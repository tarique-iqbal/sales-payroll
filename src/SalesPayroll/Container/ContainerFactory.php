<?php declare(strict_types=1);

namespace SalesPayroll\Container;

use Pimple\Container;
use SalesPayroll\Service\BonusService;
use SalesPayroll\Service\SalaryService;
use SalesPayroll\Service\ConfigService;
use SalesPayroll\Service\CLIArgsService;
use SalesPayroll\Service\CSVFileWriterService;
use SalesPayroll\SalesPayrollApplication;
use SalesPayroll\Handler\ExceptionHandler;

final readonly class ContainerFactory
{
    public function __construct(private array $config)
    {
    }

    public function create(): Container
    {
        $container = new Container();

        $container['ConfigService'] = function () {
            return new ConfigService($this->config);
        };

        $container['CLIArgsService'] = function () {
            return new CLIArgsService();
        };

        $container['SalaryService'] = function () {
            return new SalaryService();
        };

        $container['BonusService'] = function () {
            return new BonusService();
        };

        $container['CSVFileWriterService'] = function (Container $c) {
            return new CSVFileWriterService(
                $c['SalaryService'],
                $c['BonusService']
            );
        };

        $container['SalesPayrollApplication'] = function (Container $c) {
            return new SalesPayrollApplication(
                $c['ConfigService'],
                $c['CLIArgsService'],
                $c['CSVFileWriterService']
            );
        };

        $container['ExceptionHandler'] = function (Container $c) {
            return new ExceptionHandler(
                $c['ConfigService']
            );
        };

        return $container;
    }
}
