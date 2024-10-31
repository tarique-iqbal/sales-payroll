<?php declare(strict_types=1);

namespace SalesPayroll\Tests\Unit\Service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SalesPayroll\Service\CLIArgsService;
use SalesPayroll\Service\CLIArgsServiceInterface;

class CLIArgsServiceTest extends TestCase
{
    private const FILE = 'index.php';

    protected CLIArgsServiceInterface $cliArgsService;

    protected function setUp(): void
    {
        $this->cliArgsService = new CLIArgsService();
    }

    public static function addGetArgsDataProvider(): array
    {
        return [
            [
                [], // empty array
                0
            ],
            [
                [self::FILE], // no argument
                0
            ],
            [
                [self::FILE, 'a'], // single argument
                1,
                ['a']
            ],
            [
                [self::FILE, 'a', 'b'], // multi arguments
                2,
                ['a', 'b']
            ],
            [
                [self::FILE, '-a'], // single flag
                1,
                ['a' => null]
            ],
            [
                [self::FILE, '-a=b'], // single flag with value
                1,
                ['a' => 'b']
            ],
            [
                [self::FILE, '-a', '-b'], // multi flag
                2,
                ['a' => null, 'b' => null]
            ],
            [
                [self::FILE, '-ab'], // multi flag as one
                2,
                ['a' => null, 'b' => null]
            ],
            [
                [self::FILE, '-ab', 'value'], // multi flag as one with value
                2,
                ['a' => null, 'b' => 'value']
            ],
            [
                [self::FILE, '--k'], // single option without value
                1,
                ['k' => null]
            ],
            [
                [self::FILE, '--k=value'], // single option with value
                1,
                ['k' => 'value']
            ],
            [
                [self::FILE, '--k=value', '--k=overwrite'], // single option overwrite value
                1,
                ['k' => 'overwrite']
            ],
            [
                [self::FILE, '--k=value', '--k'], // single option overwrite without value
                1,
                ['k' => 'value']
            ],
            [
                [self::FILE, '--file-name=value'], // single option with dash in name
                1,
                ['file-name' => 'value']
            ],
            [
                [self::FILE, '--file-name=dummy-data.csv'], // single option with dash in name and value
                1,
                ['file-name' => 'dummy-data.csv']
            ],
            [
                [self::FILE, '--file-name=dummy-data.csv'], // single option with dash in name and value
                1,
                ['file-name' => 'dummy-data.csv']
            ],
            [
                [self::FILE, '--option=dummy=data'], // single option with equals sign in value
                1,
                ['option' => 'dummy=data']
            ],
            [
                [self::FILE, '--file-name=dummy=data'], // single option with dash in name and equals sign in value
                1,
                ['file-name' => 'dummy=data']
            ],
            [
                [self::FILE, '--option', 'value'], // single option with value without equation
                1,
                ['option' => 'value']
            ],
            [
                [self::FILE, '-ab', 'value', 'another', '-x', '--k=v', '--y'], // combination
                6,
                ['a' => null, 'b' => 'value', 'another', 'x' => null, 'k' => 'v', 'y' => null,]
            ],
        ];
    }

    #[DataProvider('addGetArgsDataProvider')]
    public function testGetArgs(array $arguments, int $countExpected, array $resultExpected = [])
    {
        $_SERVER['argv'] = $arguments;

        $result = $this->cliArgsService->getArgs();
        $this->assertEquals($countExpected, count($result));

        foreach ($result as $key => $value) {
            $this->assertSame($resultExpected[$key], $value);
        }
    }
}
