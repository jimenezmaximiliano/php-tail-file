<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail;

use JimenezMaximiliano\Tail\Exceptions\FailedToCloseFile;
use JimenezMaximiliano\Tail\Exceptions\FailedToReadFile;
use JimenezMaximiliano\Tail\Exceptions\FileClosed;

final class FileReader
{
    private string $absoluteFilePath;
    private int $cursor = 0;
    /** @var resource */
    private $fileHandle;

    /**
     * FileReader constructor.
     * @param string $absoluteFilePath
     * @throws FailedToReadFile
     */
    public function __construct(string $absoluteFilePath)
    {
        $this->absoluteFilePath = $absoluteFilePath;
        $this->openFile($this->absoluteFilePath);
    }

    /**
     * @param string $absoluteFilePath
     * @throws FailedToReadFile
     */
    private function openFile(string $absoluteFilePath): void
    {
        $fileHandle = fopen($absoluteFilePath, "r");

        if (false === $fileHandle) {
            throw new FailedToReadFile;
        }

        $this->fileHandle = $fileHandle;
    }

    /**
     * @return Character
     * @throws FileClosed
     */
    public function readPreviousCharacter(): Character
    {
        $this->rejectClosedFile();

        $this->cursor -= 1;
        $readResult = fseek($this->fileHandle, $this->cursor, SEEK_END);

        if ($readResult === -1) {
            // Nothing to read
            return new Character("");
        }

        $character = fgetc($this->fileHandle);

        if (false === $character) {
            // Nothing to read
            return new Character("");
        }

        return new Character($character);
    }

    /**
     * @throws FileClosed
     */
    private function rejectClosedFile(): void
    {
        if (!is_resource($this->fileHandle)) {
            throw new FileClosed($this->absoluteFilePath);
        }
    }

    /**
     * @throws FailedToCloseFile
     */
    public function closeFile(): void
    {
        $result = fclose($this->fileHandle);

        if (false === $result) {
            throw new FailedToCloseFile($this->absoluteFilePath);
        }
    }

    /**
     * @throws FileClosed
     */
    public function readPreviousCharacterSkippingNewLineCharacters(): Character
    {
        while (!isset($currentCharacter) || $currentCharacter->isNewLine()) {
            $currentCharacter = $this->readPreviousCharacter();
            if ($currentCharacter->isEmpty()) {
                return $currentCharacter;
            }
        }

        return $currentCharacter;
    }
}