# PHP Tail File
[![Maintenance](https://img.shields.io/badge/Maintained-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![Coverage](https://img.shields.io/badge/Coverage-88.57-yellow.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)

Efficiently tail a file from PHP

## Installation

```bash
composer require jimenezmaximiliano/php-tail-file
```

## Usage

```php
$numberOfLines = 2;
$filePath = realpath("file.log");

$lines = Tail::tail($filePath, $numberOfLines);

// ["line 30", "line 31"]
```

## Features

- It doesn't load the whole file to memory
- Skips trailing new lines and empty lines
- No dependencies