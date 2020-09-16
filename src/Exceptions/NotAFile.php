<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail\Exceptions;

use Exception;

final class NotAFile extends Exception
{
    public function __construct(string $absoluteFilePath)
    {
        parent::__construct("Not a file but a directory: " . $absoluteFilePath);
    }
}