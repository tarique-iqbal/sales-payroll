<?php declare(strict_types = 1);

namespace SalesPayroll\Validator;

/**
 * Class ArrayHasKeyValidator
 * @package SalesPayroll\Validator
 */
class ArrayHasKeyValidator
{
    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @param array $array
     * @return bool
     */
    public function isValid(array $array): bool
    {
        if (!isset($array['file'])
            && !isset($array['f'])
            && !isset($array[0])) {
            $this->errorMessage = 'Invalid input.';

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
