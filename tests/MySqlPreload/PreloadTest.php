<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\MySqlPreload;

use Codeception\Test\Unit;
use Vjik\Codeception\DatabasePopulator\Tests\MySqlPreloadTester;

final class PreloadTest extends Unit
{
    /**
     * @var MySqlPreloadTester
     */
    protected $tester;

    public function testBase(): void
    {
        $this->tester->seeInDatabase('author', ['id' => 1, 'name' => 'Ivan']);
        $this->tester->seeInDatabase('author', ['id' => 2, 'name' => 'Petr']);
    }
}
