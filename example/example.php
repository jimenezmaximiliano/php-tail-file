<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use JimenezMaximiliano\Tail\Tail;

$lines = Tail::tail(realpath("file.log"), 2);

var_dump($lines);