<?php declare(strict_types = 1);

namespace SalesPayroll\Container;

use Pimple\Container;
use SalesPayroll\Service\BonusService;
use SalesPayroll\Service\SalaryService;
use SalesPayroll\Service\ConfigService;
use SalesPayroll\Service\CLIArgsService;
use SalesPayroll\Service\CSVFileWriterService;
use SalesPayroll\Validator\FileNameValidator;
use SalesPayroll\SalesPayrollApplication;

/**
 * Class ContainerFactory
 * @package SalesPayroll
 */
class ContainerFactory
{
    /**
     * @var array
     */
    private $config;

    /**
     * ContainerFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Container
     */
    public function create(): Container
    {
        $container = new Container();

        $container['ConfigService'] = function () {
            return new ConfigService($this->config);
        };

        $container['FileNameValidator'] = function () {
            return new FileNameValidator();
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

        $container['CSVFileWriterService'] = function ($c) {
            return new CSVFileWriterService(
                $c['SalaryService'],
                $c['BonusService']
            );
        };

        $container['SalesPayrollApplication'] = function ($c) {
            return new SalesPayrollApplication(
                $c['ConfigService'],
                $c['CLIArgsService'],
                $c['CSVFileWriterService'],
                $c['FileNameValidator']
            );
        };

        return $container;
    }
}
