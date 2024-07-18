<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\PgSqlIntegration;

use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use PDO;
use Vjik\Codeception\DatabasePopulator\Tests\PgSqlIntegrationTester;

use function dirname;

final class DatabasePopulateTest extends Unit
{
    /**
     * @var PgSqlIntegrationTester
     */
    protected $tester;

    public function testBase(): void
    {
        $this->tester->loadDump('blog');
        $this->tester->loadRows('authors');

        $this->tester->seeInDatabase('author', ['id' => 1, 'name' => 'Ivan']);
        $this->tester->seeInDatabase('author', ['id' => 2, 'name' => 'Petr']);
    }

    public function testLoadNotExistDump(): void
    {
        $this->expectException(ModuleException::class);
        $this->expectExceptionMessage(
            "\nFile with dump doesn't exist.\nPlease, check path for SQL-file: " .
            dirname(__DIR__) . '/_data/dumps/pgsql/shop.sql'
        );
        $this->tester->loadDump('shop');
    }

    public function testLoadEmptyDump(): void
    {
        $this->tester->loadDump('blog');
        $this->tester->loadDump('empty');

        /** @var PDO $pdo */
        $pdo = $this->getModule('Db')->_getDbh();
        $tableNames = $pdo->query('SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\' AND table_type=\'BASE TABLE\'')->fetchAll(PDO::FETCH_COLUMN);

        $this->assertSame([], $tableNames);
    }
}
