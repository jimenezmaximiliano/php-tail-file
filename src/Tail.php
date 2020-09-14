<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail;

final class Tail
{
    /**
     * @param string $absoluteFilePath
     * @param int $numberOfLines
     * @return string[]
     * @throws Exceptions\FailedToReadFile
     * @throws Exceptions\FileClosed|Exceptions\FailedToCloseFile
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