<?php

declare(strict_types=1);

namespace Vjik\Codeception\DatabasePopulator\Tests\Unit;

use Codeception\Test\Unit;
use Vjik\Codeception\DatabasePopulator\Tests\UnitTester;

abstract class UnitTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
}
