<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\Preload;

use Codeception\Test\Unit;
use Vjik\Codeception\DatabasePopulator\Tests\PreloadTester;

final class PreloadTest extends Unit
{
    /**
     * @var PreloadTester
     */
    protected $tester;

    public function testBase(): void
    {
        $this->tester->seeInDatabase('author', ['id' => 1, 'name' => 'Ivan']);
        $this->tester->seeInDatabase('author', ['id' => 2, 'name' => 'Petr']);
    }
}
