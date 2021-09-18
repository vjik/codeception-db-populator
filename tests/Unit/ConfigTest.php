<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\Unit;

use Codeception\Test\Unit;
use Vjik\Codeception\DatabasePopulator\Config;
use Vjik\Codeception\DatabasePopulator\Tests\UnitTester;

use function dirname;

final class ConfigTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testBase(): void
    {
        $config = new Config([
            'preloadDump' => 'all',
            'preloadRows' => 'users',
            'dumpsPath' => 'tests/dumps',
            'rowsPath' => 'tests/rows',
            'mysqlDisableForeignKeyChecks' => 'false',
        ]);

        $root = dirname(__DIR__, 2);
        $this->assertSame($root . DIRECTORY_SEPARATOR . 'tests/dumps', $config->dumpsPath());
        $this->assertSame($root . DIRECTORY_SEPARATOR . 'tests/rows', $config->rowsPath());
        $this->assertFalse($config->mysqlDisableForeignKeyChecks());
    }
}
