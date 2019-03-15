<?php declare(strict_types = 1);

namespace SalesPayroll\Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use SalesPayroll\Service\ConfigService;

class ConfigServiceTest extends TestCase
{
    protected $configService;

    protected $config;

    protected function setUp()
    {
        $this->config = include BASE_DIR . '/tests/Fixture/config/params.php';
        $this->configService = new ConfigService($this->config);
    }

    public function testGetDataPath()
    {
        $dbPath = $this->configService->getDataPath();

        $this->assertDirectoryExists($dbPath);
    }

    public function testGetLogFile()
    {
        $logPath = BASE_DIR . '/' . $this->config['log']['directory'];

        $logFile = $this->configService->getLogFile();
        $expectedLogFile = BASE_DIR . '/' . $this->config['log']['directory']
                                    . '/' . $this->config['log']['file_name'];

        $this->assertDirectoryExists($logPath);
        $this->assertSame($expectedLogFile, $logFile);
    }
}
