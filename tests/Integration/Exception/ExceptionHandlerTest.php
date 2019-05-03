<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration\Exception;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Container\ContainerFactory;

class ExceptionHandlerTest extends TestCase
{
    protected $container;

    protected function setUp()
    {
        $config = include BASE_DIR . '/tests/Fixture/config/params.php';
        $this->container = (new ContainerFactory($config))->create();
    }

    protected function tearDown()
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

        $this->assertContains($message, trim(file_get_contents($logFile)));
    }
}
