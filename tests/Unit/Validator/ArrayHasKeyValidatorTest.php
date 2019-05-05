<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Validator\ArrayHasKeyValidator;

class ArrayHasKeyValidatorTest extends TestCase
{
    public function addArrayDataProvider()
    {
        return [
            [
                ['test' => 'data'], false
            ],
            [
                ['dummy' => 'data.csv'], false
            ],
            [
                [''], true
            ],
            [
                ['data.csv'], true
            ],
            [
                ['file' => 'data.csv'], true
            ],
            [
                ['f' => 'data.csv'], true
            ],
        ];
    }

    /**
     * @dataProvider addArrayDataProvider
     */
    public function testIsValid(array $fileName, bool $expectedStatus)
    {
        $arrayHasKeyValidator = new ArrayHasKeyValidator();
        $status = $arrayHasKeyValidator->isValid($fileName);

        $this->assertSame($expectedStatus, $status);
    }
}
