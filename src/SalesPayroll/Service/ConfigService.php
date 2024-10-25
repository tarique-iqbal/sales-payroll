<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

class ConfigService implements ConfigServiceInterface
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getDataPath(): string
    {
        return BASE_DIR . '/' . $this->config['data']['directory'];
    }

    public function getErrorLogFile(): string
    {
        return BASE_DIR . '/' . $this->config['error_log']['directory']
                        . '/' . $this->config['error_log']['file_name'];
    }
}
