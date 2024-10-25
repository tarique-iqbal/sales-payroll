<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

interface CLIArgsServiceInterface
{
    /**
     * @return array
     */
    public function getArgs(): array;
}
