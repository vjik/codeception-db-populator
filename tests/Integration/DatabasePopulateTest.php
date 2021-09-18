<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\Integration;

use Codeception\Exception\ModuleException;
use Codeception\Test\Unit;
use PDO;
use Vjik\Codeception\DatabasePopulator\Tests\IntegrationTester;

use function dirname;

final class DatabasePopulateTest extends Unit
{
    /**
     * @var IntegrationTester
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
            dirname(__DIR__) . '/_data/dumps/shop.sql'
        );
        $this->tester->loadDump('shop');
    }

    public function testLoadEmptyDump(): void
    {
        $this->tester->loadDump('blog');
        $this->tester->loadDump('empty');

        /** @var PDO $pdo */
        $pdo = $this->getModule('Db')->_getDbh();
        $tableNames = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        $this->assertSame([], $tableNames);
    }
}
