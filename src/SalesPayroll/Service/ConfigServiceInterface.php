<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

/**
 * Interface ConfigServiceInterface
 * @package SalesPayroll\Service
 */
interface ConfigServiceInterface
{
    /**
     * @return string
     */
    public function getDataPath(): string;

    /**
     * @return string
     */
    public function getErrorLogFile(): string;
}
