<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

interface ConfigServiceInterface
{
    public function getDataPath(): string;

    public function getErrorLogFile(): string;
}
