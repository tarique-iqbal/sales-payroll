<?php declare(strict_types = 1);

namespace SalesPayroll\Exception;

use SalesPayroll\Service\ConfigServiceInterface;

/**
 * Class Handler
 * @package SalesPayroll\Exception
 */
class ExceptionHandler
{
    /**
     * @var ConfigServiceInterface
     */
    private ConfigServiceInterface $configService;

    /**
     * ExceptionHandler constructor.
     * @param ConfigServiceInterface $configService
     */
    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param \Throwable $e
     */
    public function report(\Throwable $e): void
    {
        $message = $e->getMessage();
        $logFile = $this->configService->getErrorLogFile();

        error_log($message . PHP_EOL, 3, $logFile);

        echo 'Exception occurred! Please check errors log file: ' . $logFile . PHP_EOL;
    }
}
