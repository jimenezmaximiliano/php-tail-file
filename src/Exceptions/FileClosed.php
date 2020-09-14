<?php
declare(strict_types=1);
namespace JimenezMaximiliano\Tail\Exceptions;

use Exception;

final class FileClosed extends Exception
{
    public function __construct(string $absoluteFilePath)
    {
        parent::__construct("File closed: " . $absoluteFilePath);
    }
}