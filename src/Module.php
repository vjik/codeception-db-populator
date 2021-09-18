<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator;

use function is_array;

/**
 * @psalm-type ModuleConfigArray = array<string,mixed>&array{
 *     preloadDump: string|string[]|null,
 *     preloadRows: string|string[]|null,
 *     dumpsPath: string,
 *     rowsPath: string,
 * }
 */
final class Module extends \Codeception\Module
{
    /**
     * @psalm-suppress NonInvariantDocblockPropertyType
     * @psalm-suppress InvalidPropertyAssignmentValue
     * @psalm-var ModuleConfigArray
     */
    protected $config = [
        'preloadDump' => null,
        'preloadRows' => null,
    ];

    /**
     * @psalm-suppress NonInvariantDocblockPropertyType
     * @var string[]
     */
    protected $requiredFields = [
        'dumpsPath',
        'rowsPath',
    ];

    private ?DatabasePopulator $popualtor = null;

    public function _beforeSuite($settings = []): void
    {
        if ($this->config['preloadDump'] !== null) {
            $dumps = is_array($this->config['preloadDump'])
                ? $this->config['preloadDump']
                : [$this->config['preloadDump']];
            $this->getPopulator()->loadDump(...$dumps);
        }
        if ($this->config['preloadRows'] !== null) {
            $sets = is_array($this->config['preloadRows'])
                ? $this->config['preloadRows']
                : [$this->config['preloadRows']];
            $this->getPopulator()->loadRows(...$sets);
        }
    }

    public function loadDump(string ...$dumps): void
    {
        $this->getPopulator()->loadDump(...$dumps);
    }

    public function loadRows(string ...$sets): void
    {
        $this->getPopulator()->loadRows(...$sets);
    }

    private function getPopulator(): DatabasePopulator
    {
        if ($this->popualtor === null) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $this->popualtor = new DatabasePopulator(
                $this->getModule('Db'),
                new Config($this->config)
            );
        }
        return $this->popualtor;
    }
}
