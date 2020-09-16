<?php
declare(strict_types=1);

namespace Tests;

use JimenezMaximiliano\Tail\Exceptions\FailedToReadFile;
use JimenezMaximiliano\Tail\Exceptions\NotAFile;
use JimenezMaximiliano\Tail\Exceptions\NotSeekable;
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

    public function testReadingFromAnEmptyFile(): void
    {
        $lines = Tail::tail(realpath("tests/files/empty.log"), 3);

        $this->assertSame([], $lines);
    }

    public function testReadingFromANonExistentFile(): void
    {
        $this->expectException(FailedToReadFile::class);

        Tail::tail("/tests/files/asdf.log", 3);
    }

    public function testReadingNegativeNumberOfLines(): void
    {
        $lines = Tail::tail(realpath("tests/files/perfect_two_lines.log"), -1);

        $this->assertSame([], $lines);
    }

    public function testReadingFromAFileWithTrailingNewLines(): void
    {
        $lines = Tail::tail(realpath("tests/files/lines_and_trailing_new_lines.log"), 2);

        $this->assertSame(['line one', 'line two'], $lines);
    }

    public function testReadingFromAFileWithEmptyLines(): void
    {
        $lines = Tail::tail(realpath("tests/files/lines_with_empty_lines.log"), 4);

        $this->assertSame(['line one', 'line two'], $lines);
    }

    public function testReadingFromADirectory(): void
    {
        $this->expectException(NotAFile::class);
        Tail::tail(realpath("tests/files/"), 1);
    }

    public function testReadingFromAnUrl(): void
    {
        $this->expectException(NotSeekable::class);
        Tail::tail("http://google.com", 1);
    }
}