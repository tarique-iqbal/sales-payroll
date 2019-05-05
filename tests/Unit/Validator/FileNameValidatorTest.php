<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Unit\Validator;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Validator\FileNameValidator;

class FileNameValidatorTest extends TestCase
{
    public function addFileNameDataProvider()
    {
        return [
            ['', false],
            ['1data.csv', false],
            ['data_file.csv', false],
            ['data.txt', false],
            ['data', false],
            ['data.csv', true],
            ['data-01.03.2019.csv', true],
        ];
    }

    /**
     * @dataProvider addFileNameDataProvider
     */
    public function testIsValid(string $fileName, bool $expectedStatus)
    {
        $fileNameValidator = new FileNameValidator();
        $status = $fileNameValidator->isValid($fileName);

        $this->assertSame($expectedStatus, $status);
    }
}
