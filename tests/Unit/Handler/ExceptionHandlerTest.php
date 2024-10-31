<?php declare(strict_types=1);

namespace SalesPayroll\Tests\Unit\Handler;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use SalesPayroll\Handler\ExceptionHandler;
use SalesPayroll\Service\ConfigServiceInterface;

class ExceptionHandlerTest extends TestCase
{
    private vfsStreamDirectory $root;

    protected function setUp(): void
    {
        $structure = [
            'logs' => [
                'errors.log' => ''
            ]
        ];

        $this->root = vfsStream::setup(sys_get_temp_dir(), null, $structure);
    }

    public function testReport(): void
    {
        $this->expectOutputString(
            'Exception occurred! Please check errors log file: vfs://tmp/logs/errors.log' . PHP_EOL
        );

        $configService = $this
            ->getMockBuilder(ConfigServiceInterface::class)
            ->getMock();
        $configService->method('getErrorLogFile')->willReturn(
            $this->root->url() . '/logs/errors.log'
        );

        $message = 'Exception message to write in log file.';

        (new ExceptionHandler($configService))->report(new \Exception($message));

        $this->assertTrue($this->root->hasChild('logs/errors.log'));
        $this->assertStringContainsString(
            'Exception message to write in log file.',
            $this->root->getChild('logs/errors.log')->getContent()
        );
    }
}
