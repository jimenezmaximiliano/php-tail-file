<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail;

use JimenezMaximiliano\Tail\Exceptions\FailedToCloseFile;
use JimenezMaximiliano\Tail\Exceptions\FailedToReadFile;
use JimenezMaximiliano\Tail\Exceptions\FileClosed;
use JimenezMaximiliano\Tail\Exceptions\NotAFile;
use JimenezMaximiliano\Tail\Exceptions\NotSeekable;

final class Tail
{
    /**
     * @param string $absoluteFilePath
     * @param int $numberOfLines
     * @return string[]
     * @throws FailedToReadFile
     * @throws FileClosed
     * @throws FailedToCloseFile
     * @throws NotSeekable
     * @throws NotAFile
     */
    public static function tail(string $absoluteFilePath, int $numberOfLines): array
    {
        $lines = [];

        $fileReader = new FileReader($absoluteFilePath);
        $currentCharacter = $fileReader->readPreviousCharacterSkippingNewLineCharacters();

        $currentLine = "";

        while ($currentCharacter->isPartOfALine() && count($lines) < $numberOfLines) {
            $currentLine = $currentCharacter->get() . $currentLine;
            $currentCharacter = $fileReader->readPreviousCharacter();

            if ($currentCharacter->isNewLine()) {
                $lines[] = $currentLine;
                $currentLine = "";
                $currentCharacter = $fileReader->readPreviousCharacterSkippingNewLineCharacters();
            }
        }

        if (!empty($currentLine)) {
            $lines[] = $currentLine;
        }

        $fileReader->closeFile();

        return array_reverse($lines);
    }
}