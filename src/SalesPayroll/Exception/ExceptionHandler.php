<?php declare(strict_types = 1);

namespace SalesPayroll\Exception;

use SalesPayroll\Service\ConfigServiceInterface;

final readonly class ExceptionHandler
{
    public function __construct(private ConfigServiceInterface $configService)
    {
    }

    public function report(\Throwable $e): void
    {
        $message = $e->getMessage();
        $logFile = $this->configService->getErrorLogFile();

        error_log($message . PHP_EOL, 3, $logFile);

        echo 'Exception occurred! Please check errors log file: ' . $logFile . PHP_EOL;
    }
}
