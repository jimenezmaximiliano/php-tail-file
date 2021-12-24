# PHP Tail File
[![Latest Version](https://img.shields.io/github/release/jimenezmaximiliano/php-tail-file.svg?style=flat-square)](https://github.com/jimenezmaximiliano/php-tail-file/releases)
[![Maintenance](https://img.shields.io/badge/Maintained-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![Build Status](https://img.shields.io/github/workflow/status/jimenezmaximiliano/php-tail-file/CI?label=ci%20build&style=flat-square)](https://github.com/jimenezmaximiliano/php-tail-file/actions?query=workflow%3ACI)
[![Coverage](https://img.shields.io/badge/Coverage-88.57-yellow.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)

Efficiently tail a file from PHP - Reads the last x number of lines of a file
(similar to Unix's tail command)

![](https://www.aaha.org/contentassets/2b0aa3d3881d4d80a4d9237b193cd4ad/askaaha_thumbs_limbertail.jpg)

- Great performance
- It doesn't load the whole file to memory
- Skips trailing new lines and empty lines
- No dependencies
- Tested on Linux, Windows and macOS
- Compatible with PHP 7.4, 8 and 8.1

Usually used to read the last lines of:

- CSV files
- Log files
- JSON files
- text files

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
