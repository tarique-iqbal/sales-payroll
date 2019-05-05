<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Validator\ArraySizeValidator;

class ArraySizeValidatorTest extends TestCase
{
    public function addArrayDataProvider()
    {
        return [
            [
                [], 1, false
            ],
            [
                ['', ''], 1, false
            ],
            [
                ['example.csv', 'data.csv', 'dummy.csv'], 1, false
            ],
            [
                ['file' => 'data.csv'], 1, true
            ],
            [
                ['data.csv'], 1, true
            ],
        ];
    }

    /**
     * @dataProvider addArrayDataProvider
     */
    public function testIsValid(array $array, int $inputSize, bool $expectedStatus): void
    {
        $arraySizeValidator = new ArraySizeValidator();
        $status = $arraySizeValidator->isValid($array, $inputSize);

        $this->assertSame($expectedStatus, $status);
    }
}
