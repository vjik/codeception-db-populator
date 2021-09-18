<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator;

/**
 * @internal
 *
 * @psalm-import-type ModuleConfigArray from Module
 */
final class Config
{
    private string $dumpsPath;
    private string $rowsPath;
    private bool $mysqlDisableForeignKeyChecks;

    /**
     * @psalm-param ModuleConfigArray $config
     */
    public function __construct(array $config)
    {
        $this->dumpsPath = codecept_absolute_path($config['dumpsPath']);
        $this->rowsPath = codecept_absolute_path($config['rowsPath']);
        $this->mysqlDisableForeignKeyChecks = filter_var(
            $config['mysqlDisableForeignKeyChecks'],
            FILTER_VALIDATE_BOOLEAN
        );
    }

    public function dumpsPath(): string
    {
        return $this->dumpsPath;
    }

    public function rowsPath(): string
    {
        return $this->rowsPath;
    }

    public function mysqlDisableForeignKeyChecks(): bool
    {
        return $this->mysqlDisableForeignKeyChecks;
    }
}
