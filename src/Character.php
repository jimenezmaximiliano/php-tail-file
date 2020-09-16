<?php
declare(strict_types=1);

namespace JimenezMaximiliano\Tail;

final class Character
{
    private string $character;

    public function __construct(string $character)
    {
        $this->character = $character;
    }

    public function get(): string
    {
        return $this->character;
    }

    public function isNewLine(): bool
    {
        return "\n" === $this->character || "\r" === $this->character;
    }

    public function isNotNewLine(): bool
    {
        return !$this->isNewLine();
    }

    public function isEmpty(): bool
    {
        return "" === $this->character;
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function isPartOfALine(): bool
    {
        return $this->isNotNewLine() && $this->isNotEmpty();
    }
}