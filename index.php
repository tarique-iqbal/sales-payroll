<?php declare(strict_types = 1);

use SalesPayroll\Container\ContainerFactory;

ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'Off');

const BASE_DIR = __DIR__;

if (php_sapi_name() !== 'cli') {
    die('Please run the application from command line.');
}

require_once BASE_DIR . '/vendor/autoload.php';
$config = include BASE_DIR . '/config/params.php';

$container = (new ContainerFactory($config))->create();
$salesPayrollApplication = $container['SalesPayrollApplication'];

set_exception_handler([$container['ExceptionHandler'], 'report']);

$salesPayrollApplication->writeSalaryBonusPaymentDates();
