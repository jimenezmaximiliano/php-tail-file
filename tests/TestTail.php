<?php
declare(strict_types=1);

namespace Tests;

use JimenezMaximiliano\Tail\Tail;
use PHPUnit\Framework\TestCase;

final class TestTail extends TestCase
{
    public function testReadingLastLine(): void
    {
        $lines = Tail::tail(realpath("tests/files/perfect_five_lines.log"), 1);

        $this->assertSame(['line five'], $lines);
    }

    public function testReadingTwoLines(): void
    {
        $lines = Tail::tail(realpath("tests/files/perfect_five_lines.log"), 2);

        $this->assertSame(['line four', 'line five'], $lines);
    }

    public function testReadingMoreLinesThanPossible(): void
    {
        $lines = Tail::tail(realpath("tests/files/perfect_two_lines.log"), 3);

        $this->assertSame(['line one', 'line two'], $lines);
    }
}