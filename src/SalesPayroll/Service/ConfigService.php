<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

/**
 * Class ConfigService
 * @package SalesPayroll\Service
 */
class ConfigService implements ConfigServiceInterface
{
    /**
     * @var array
     */
    private array $config = [];

    /**
     * ConfigService constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getDataPath(): string
    {
        return BASE_DIR . '/' . $this->config['data']['directory'];
    }

    /**
     * @return string
     */
    public function getErrorLogFile(): string
    {
        return BASE_DIR . '/' . $this->config['error_log']['directory']
                        . '/' . $this->config['error_log']['file_name'];
    }
}
