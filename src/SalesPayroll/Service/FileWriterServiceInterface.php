<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

use SalesPayroll\Exception\FileOpenException;

interface FileWriterServiceInterface
{
    public function writeFile(string $csvFileLocation, int $numberOfMonths, string $today): void;
}
