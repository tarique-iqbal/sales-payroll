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
        $this->config = include BASE_DIR . '/config/params_test.php';
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

        $logFile = $this->configService->getErrorLogFile();
        $expectedLogFile = BASE_DIR . '/' . $this->config['error_log']['directory']
                                    . '/' . $this->config['error_log']['file_name'];

        $this->assertDirectoryExists($logPath);
        $this->assertSame($expectedLogFile, $logFile);
    }
}
