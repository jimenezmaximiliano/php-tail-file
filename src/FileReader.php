<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail;

use Exception;
use JimenezMaximiliano\Tail\Exceptions\FailedToCloseFile;
use JimenezMaximiliano\Tail\Exceptions\FailedToReadFile;
use JimenezMaximiliano\Tail\Exceptions\FileClosed;
use JimenezMaximiliano\Tail\Exceptions\NotAFile;
use JimenezMaximiliano\Tail\Exceptions\NotSeekable;

final class FileReader
{
    private string $absoluteFilePath;
    private int $cursor = 0;
    /** @var resource */
    private $fileHandle;

    /**
     * @param string $absoluteFilePath
     * @throws FailedToReadFile
     * @throws NotAFile
     */
    public function __construct(string $absoluteFilePath)
    {
        $this->absoluteFilePath = $absoluteFilePath;
        $this->openFile($this->absoluteFilePath);
    }

    /**
     * @param string $absoluteFilePath
     * @throws FailedToReadFile
     * @throws NotAFile
     */
    private function openFile(string $absoluteFilePath): void
    {
        $this->rejectDirectory($absoluteFilePath);

        try {
            $fileHandle = fopen($absoluteFilePath, "r");
        } catch (Exception $exception) {
            throw new FailedToReadFile($absoluteFilePath, $exception);
        }

        if (false === $fileHandle) {
            throw new FailedToReadFile($absoluteFilePath);
        }

        $this->fileHandle = $fileHandle;
    }

    /**
     * @param string $absoluteFilePath
     * @throws NotAFile
     */
    private function rejectDirectory(string $absoluteFilePath): void
    {
        if (is_dir($absoluteFilePath)) {
            throw new NotAFile($absoluteFilePath);
        }
    }

    /**
     * @return Character
     * @throws FileClosed|NotSeekable
     */
    public function readPreviousCharacter(): Character
    {
        $this->rejectClosedFile();

        $this->cursor -= 1;
        try {
            $readResult = fseek($this->fileHandle, $this->cursor, SEEK_END);
        } catch(Exception $exception) {
            throw new NotSeekable($this->absoluteFilePath, $exception);
        }

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
     * @throws NotSeekable
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