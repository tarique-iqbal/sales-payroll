<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration\Exception;

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use SalesPayroll\Container\ContainerFactory;

class ExceptionHandlerTest extends TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/params_test.php';
        $this->container = (new ContainerFactory($config))->create();
    }

    protected function tearDown(): void
    {
        $configService = $this->container['ConfigService'];
        $logFile = $configService->getErrorLogFile();

        if (file_exists($logFile)) {
            unlink($logFile);
        }
    }

    public function testHandle()
    {
        $configService = $this->container['ConfigService'];
        $exceptionHandler = $this->container['ExceptionHandler'];

        $logFile = $configService->getErrorLogFile();
        $message = 'Exception message to write in log file.';

        $exceptionHandler->report(new \Exception($message));

        $this->assertStringContainsString($message, trim(file_get_contents($logFile)));
    }
}
