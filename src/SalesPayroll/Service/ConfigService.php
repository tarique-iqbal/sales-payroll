<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

final readonly class ConfigService implements ConfigServiceInterface
{
    public function __construct(private array $config)
    {
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
