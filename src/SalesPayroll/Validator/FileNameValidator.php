<?php declare(strict_types = 1);

namespace SalesPayroll\Validator;

/**
 * Class FileNameValidator
 * @package SalesPayroll\Validator
 */
class FileNameValidator
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param string $fileName
     * @return bool
     */
    public function isValid(string $fileName): bool
    {
        if (trim($fileName) === '') {
            $this->errorMessage = 'File name cannot be empty.' . PHP_EOL;

            return false;
        }

        if (!preg_match('/^[a-z]{1}[a-z0-9\.\-]+\.csv$/i', $fileName)) {
            $this->errorMessage = 'File name contain only a-z, 0-9, dot (.), hyphen (-) with csv extension.' . PHP_EOL;

            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
