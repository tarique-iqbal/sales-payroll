<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

use SalesPayroll\Exception\FileOpenException;

/**
 * Interface BonusServiceInterface
 * @package SalesPayroll\Service
 */
interface FileWriterServiceInterface
{
    /**
     * @param string $csvFileLocation
     * @param int $numberOfMonths
     * @param string $today
     * @throws FileOpenException
     */
    public function writeFile(string $csvFileLocation, int $numberOfMonths, string $today): void;
}
