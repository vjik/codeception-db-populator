<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator;

use Codeception\Exception\ModuleException;
use Codeception\Lib\Driver\Db as DbDriver;
use Codeception\Lib\Driver\MySql as MySqlDriver;
use Codeception\Module\Db;
use PDO;

/**
 * @internal
 */
final class DatabasePopulator
{
    private DbDriver $dbDriver;
    private PDO $dbh;
    private Config $config;

    public function __construct(Db $db, Config $config)
    {
        $this->dbDriver = $db->_getDriver();
        /** @var PDO */
        $this->dbh = $db->_getDbh();
        $this->config = $config;
    }

    public function loadDump(string ...$dumps): void
    {
        // Clear database
        $this->dbDriver->cleanup();

        // Load dumps
        foreach ($dumps as $dump) {
            $this->dbDriver->load($this->readDump($dump));
        }
    }

    public function loadRows(string ...$sets): void
    {
        $this->beforeLoadRows();

        foreach ($sets as $set) {
            /**
             * @psalm-suppress UnresolvableInclude
             * @psalm-var array<string, array<string,array>> $data
             */
            $data = require $this->getRowsFilePath($set);
            foreach ($data as $table => $rows) {
                $this->insertRows($table, $rows);
            }
        }

        $this->afterLoadRows();
    }

    /**
     * @param array[] $rows
     */
    private function insertRows(string $table, array $rows): void
    {
        $requests = [];
        foreach ($rows as $row) {
            $columns = array_keys($row);
            $key = implode('~', $columns);
            if (isset($requests[$key])) {
                $requests[$key]['rows'][] = $row;
            } else {
                $requests[$key] = [
                    'columns' => $columns,
                    'rows' => [$row],
                ];
            }
        }

        foreach ($requests as $request) {
            $columns = array_map(static fn ($c) => "`$c`", $request['columns']);
            $sql = 'INSERT INTO ' . $table . ' (' . implode(',', $columns) . ') VALUES ';

            $insertQuery = [];
            $insertData = [];
            $n = 0;
            foreach ($request['rows'] as $row) {
                $insertQueryData = [];

                /** @var mixed $value */
                foreach ($row as $key => $value) {
                    $insertQueryData[] = ':' . $key . $n;
                    /** @var mixed */
                    $insertData[$key . $n] = $value;
                }

                $insertQuery[] = '(' . implode(',', $insertQueryData) . ')';
                $n++;
            }

            $sql .= implode(', ', $insertQuery);
            $this->dbh->prepare($sql)->execute($insertData);
        }
    }

    private function beforeLoadRows(): void
    {
        if ($this->dbDriver instanceof MySqlDriver) {
            if ($this->config->mysqlDisableForeignKeyChecks()) {
                $this->dbh->prepare('SET FOREIGN_KEY_CHECKS = 0')->execute();
            }
        }
    }

    private function afterLoadRows(): void
    {
        if ($this->dbDriver instanceof MySqlDriver) {
            if ($this->config->mysqlDisableForeignKeyChecks()) {
                $this->dbh->prepare('SET FOREIGN_KEY_CHECKS = 1')->execute();
            }
        }
    }

    /**
     * @see Db::readSqlFile
     * @see Db::readSql
     */
    private function readDump(string $dump): array
    {
        $file = $this->getDumpFilePath($dump);

        if (!file_exists($file)) {
            throw new ModuleException(
                Module::class,
                "\nFile with dump doesn't exist.\nPlease, check path for SQL-file: $file"
            );
        }

        $sql = file_get_contents($file);

        // Remove C-style comments (except MySQL directives)
        $sql = preg_replace('%/\*(?!!\d+).*?\*/%s', '', $sql);

        if (empty($sql)) {
            return [];
        }

        // Split SQL dump into lines
        return preg_split('/\r\n|\n|\r/', $sql, -1, PREG_SPLIT_NO_EMPTY);
    }

    private function getDumpFilePath(string $dump): string
    {
        return $this->config->dumpsPath() . '/' . $dump . '.sql';
    }

    private function getRowsFilePath(string $set): string
    {
        return $this->config->rowsPath() . '/' . $set . '.php';
    }
}
