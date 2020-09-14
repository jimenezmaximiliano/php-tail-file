<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail\Exceptions;

use Exception;

final class FailedToReadFile extends Exception
{
    public function __construct(string $absoluteFilePath)
    {
        parent::__construct("Could not open file for reading: " . $absoluteFilePath);
    }
}