<?php declare(strict_types=1);

namespace SalesPayroll\Utility;

class Utility
{
    public static function isFileExists(string $csvFileLocation): bool
    {
        if (file_exists($csvFileLocation)) {
            return true;
        }

        return false;
    }

    public static function isOverwriteFile(string $fileName): bool
    {
        echo sprintf('%s file already exists! Are you sure you want to overwrite it (y/n)? :', $fileName);

        $handle = fopen('php://stdin', 'r');
        $line = fgets($handle);

        if (strtolower(trim($line)) === 'y') {
            return true;
        }

        echo sprintf('Action aborted.%s', PHP_EOL);

        return false;
    }
}
